<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('lastname')->setLabel('Nom'),
            TextField::new('firstname')->setLabel('Prénom'),
            ChoiceField::new('roles')->setChoices([
                'User' => 'ROLE_USER',
                'Employes' => 'ROLE_ADMIN',
                'Administrateur' => 'ROLE_SUPER_ADMIN'
            ])
            ->allowMultipleChoices()
            ->autocomplete()
            ->setLabel('ROLE(S)'),
            EmailField::new('email')->setLabel('Email'),
            BooleanField::new('rgpd')->setLabel('RGPD')->hideOnIndex(),
            BooleanField::new('isVerifyEd')->setLabel('COMPTE ACTIVE')->hideOnIndex(),
            BooleanField::new('isblocked')->setLabel('BLOQUE')->hideOnIndex(),
            DateTimeField::new('createdAt')->setLabel('DATE DE CREATION')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('updatedAt')->setLabel('DERNIERE MISE A JOUR')->hideOnForm()->hideOnIndex()
        ];
    }
    
}
