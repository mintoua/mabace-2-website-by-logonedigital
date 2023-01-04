<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $post = $this->getEntityFqcn();
        return $crud
        ->setPageTitle('index', 'Gérer vos articles')
        ->setPageTitle('new', 'Ajouter un nouvelle articles')
        ->setPageTitle('detail', "Article")
        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')
            ->setLabel('Titre'),
            ImageField::new('image')
                ->setLabel('Image')
                ->setBasePath('uploads/images/BlogImages')
                ->setUploadDir('public/uploads/images/BlogImages')
                ->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
            //TextareaField::new('content'),
            AssociationField::new('categoryPost')->setLabel('Thématique'),
            TextareaField::new('content')
                ->setLabel('Contenu')
                ->setFormType(CKEditorType::class)
                ->hideOnIndex()
                ->renderAsHtml(),
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
    
}
