<?php

namespace App\Controller\Admin;

use App\Entity\Projet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ProjetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Projet::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('intitule')
                ->setLabel('Intitulé du projet'),
            ImageField::new('image')
                ->setLabel('Image')
                ->hideOnIndex ()
                ->setBasePath('uploads/images/ProjetsImages')
                ->setUploadDir('public/uploads/images/ProjetsImages')
                ->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
            TextareaField::new('description')
                ->setLabel('Description du projet')
                ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
                ->setFormType (CKEditorType::class)
                ->renderAsHtml (),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        $post = $this->getEntityFqcn();
        return $crud
            ->setPageTitle('index', 'Gérer vos projets')
            ->setPageTitle('new', 'Ajouter un nouveau projet')
            ->setPageTitle('detail', "Projet")
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
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
