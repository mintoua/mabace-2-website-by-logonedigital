<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("new_password", RepeatedType::class, [
                'type'=>PasswordType::class,
                'invalid_message'=> 'le mot de passe et la confirmation doivent être identique.',
                'first_options'=>[
                    'constraints'=>[
                        new Regex(
                    [
                        "pattern"=>"/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/",
                        "match"=>true,
                        "message"=>"mot de passe invalid"
                    ]
                    ),
                    ],
                    'attr'=> [
                        'placeholder'=>'nouveaux mot de passe'
                    ],
                    
                    'help'=> 'Le mot de passe doit contenir au moins 8 caractères, dont au moins: une Majuscule, un chiffre, un caractère spéciale.',
                    ],
                'second_options'=>[
                    'attr'=> [
                        'placeholder'=>'Confirmez votre mot de passe'
                    ]
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
