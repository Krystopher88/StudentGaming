<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\AppAuthenticator;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request,
    UserPasswordHasherInterface $userPasswordHasher,
    UserAuthenticatorInterface $userAuthenticator,
    AppAuthenticator $authenticator,
    EntityManagerInterface $entityManager,
    SendMailService $sendMailService,
    JWTService $jwt): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $header = [
                'alg' => 'HS256',
                'typ' => 'JWT'
            ];
            $payload = [
                'user_id' => $user->getId(),
            ];

            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));
            
            $sendMailService->send(
                'noreply@studentgaming.com',
                $user->getEmail(),
                'Bienvenue chez StudentGaming, activez votre compte',
                'register',
                [
                    'user' => $user,
                    'token' => $token
                ]
            );

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/activation/{token}', name:'activ_user')]
    public function activateUser($token,
    JWTService $jwt,
    UsersRepository $usersRepository,
    EntityManagerInterface $entityManagerInterface):Response
    {
        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter(('app.jwtsecret'))))
        {
            $payload = $jwt->getPayload($token);
            $user = $usersRepository->find($payload['user_id']);
            if($user && !$user->getIsVerified()){
                $user->setIsVerified(true);
                $entityManagerInterface->flush($user);

                $this->addFlash('success', 'Votre compte est activé');
                return $this->redirectToRoute('profil_index');
            }
            
        }
        $this->addFlash('danger', 'Le lien d\'activation est invalide ou expiré');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/renvoitoken', name:'resend_token')]
    public function resendToken(JWTService $jwt, SendMailService $sendMailService, UsersRepository $usersRepository):Response
    {
        $user = $this->getUser();
        if(!$user){
            $this->addFlash('danger', 'Vous devez être connecté');
            return $this->redirectToRoute('app_login');
        }

        if($user->getIsVerified()){
            $this->addFlash('warning', 'Vous avez déjà activé votre compte');
            return $this->redirectToRoute('profil_index');
        }

        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];
        $payload = [
            'user_id' => $user->getId(),
        ];

        $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));
        
        $sendMailService->send(
            'noreply@studentgaming.com',
            $user->getEmail(),
            'Bienvenue chez StudentGaming, activez votre compte',
            'register',
            [
                'user' => $user,
                'token' => $token
            ]

        );
        $this->addFlash('success', 'Email de d\'activation renvoyer');
        return $this->redirectToRoute('profil_index');
    }
}
