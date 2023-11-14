<?php

namespace App\Controller\Admin;


use App\Entity\Games;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GamesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Games::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Jeux Vidéo')
            ->setPageTitle('edit', 'Modifier un Jeux Vidéo')
            ->setPageTitle('new', 'Ajouter un Jeux Vidéo')
            ->setPaginatorPageSize(10)
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Créer un Jeux Video');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new ('id', 'ID')->onlyOnIndex();
        yield TextField::new ('title', 'Titre');
        yield SlugField::new ('slug', 'Slug')->setTargetFieldName('title')->onlyOnForms();
        yield TextEditorField::new ('description', 'Résumé')
            ->hideOnIndex();
        yield IntegerField::new ('note', 'Note')->hideOnIndex();
        yield DateField::new ('release_date', 'Date de sortie')->hideOnIndex();
        yield DateField::new ('created_at', 'Date de créations');
        yield BooleanField::new ('multiplayer', 'Multijoueurs ?')->hideOnIndex();
        yield AssociationField::new ('category', 'Genre')->hideOnIndex();
        yield AssociationField::new ('pegi', 'PEGI');
    }
}
