<?php

namespace App\Controller\Admin;

use App\Entity\Pegi;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class PegiCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pegi::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'PEGI')
            ->setPageTitle('edit', 'Modifier un PEGI')
            ->setPageTitle('new', 'Ajouter un PEGI')
            ->setPaginatorPageSize(10)
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Créer un PEGI');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('age', 'PEGI');
    }
}
