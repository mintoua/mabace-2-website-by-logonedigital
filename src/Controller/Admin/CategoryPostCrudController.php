<?php

namespace App\Controller\Admin;

use App\Entity\CategoryPost;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryPostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoryPost::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('designation')->setLabel('Thématique'),
        ];
    }
    

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ->add(Crud::PAGE_EDIT, Action::INDEX)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setPageTitle('index', 'Gérer vos thématiques')
        ->setPageTitle('new', 'Ajouter une nouvelle thématique')
        ;
    }
}
