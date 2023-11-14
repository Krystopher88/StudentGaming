<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UsersCrudController extends AbstractCrudController
{   
    private $sendMailService;

    public function __construct(SendMailService $sendMailService)
    {
        $this->sendMailService = $sendMailService;
    }

    public static function getEntityFqcn(): string
    {
        return Users::class;
    }

    // public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    // {
    //     $entityManager->persist($entityInstance);
    //     $entityManager->flush();

    //     $this->sendMailService->send(
    //         'noreply@studentgaming.com',
    //         $user->getEmail(),
    //         'Bienvenue chez StudentGaming, activez votre compte',
    //         'register',
    //         [
    //             'user' => $user,
    //             'token' => $token
    //         ]

    //     );
    // }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setPageTitle('index', 'Utilisateurs')
        ->setPageTitle('edit', 'Modifier un utilisateur')
        ->setPageTitle('new', 'Ajouter un utilisateur')
        ->setPaginatorPageSize(10)
        ;
    }

    public function configureActions(Actions $actions): Actions
{
    $createAndSendEmailAction = Action::new('createAndSendEmail', 'Créer un utilisateur et envoyer un e-mail (in Progress)')
        ->linkToRoute('create_and_send_email_action');

    return $actions
        ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
            return $action->setLabel('Créer un utilisateur');
        })
        ->add(Crud::PAGE_NEW, $createAndSendEmailAction);
}

    
    public function configureFields(string $pageName): iterable
    {
        yield EmailField::new('email');
        yield TextField::new('password')->onlyWhenCreating();
        yield TextField::new('lastname', 'Nom');
        yield TextField::new('firstname', 'Prénom');
        yield TextareaField::new('address', 'Adresse')->hideOnIndex();
        yield TextField::new('zipcode', 'Code postal')->hideOnIndex();
        yield TextField::new('city', 'Ville')->hideOnIndex();
        yield BooleanField::new('isVerified', 'Compte validé');
    }
    
}
