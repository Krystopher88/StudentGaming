<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil', name: 'profil_')]
class ProfilController extends AbstractController
{
    
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $user = $this->getUser();
        if(!$user){
            $this->addFlash('danger', 'Vous devez être connecté');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'Mon Profil',
            'user' => $user,
        ]);
    }

    #[Route('/commandes', name: 'orders')]
    public function orders(): Response
    {
        $user = $this->getUser();
        if(!$user){
            $this->addFlash('danger', 'Vous devez être connecté');
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('profil/orders.html.twig', [
            'controller_name' => 'Vos commandes',
        ]);
    }
}
