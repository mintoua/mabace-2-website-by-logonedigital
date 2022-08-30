<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('designation')
                ->setLabel('Intitulé du service'),
            ImageField::new('image')
                ->setLabel('Image')
                ->setBasePath('uploads/images/ServiceImages')
                ->setUploadDir('public/uploads/images/ServiceImages')
                ->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
            //TextareaField::new('content'),
            AssociationField::new('ServiceCategory')->setLabel('Catégorie du service'),
            TextareaField::new('description')
                ->setLabel('Description du service')
                ->renderAsHtml(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        $post = $this->getEntityFqcn();
        return $crud
            ->setPageTitle('index', 'Gérer les services')
            ->setPageTitle('new', 'Ajouter un service')
            ->setPageTitle('detail', "Service")
            ;
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
}
