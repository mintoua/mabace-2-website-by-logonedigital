<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, [
                "constraints" => [
                    new Regex(
                        [
                            "pattern"=>"/\d/",
                            "match"=>false,
                            "message"=>"le nom ne doit pas contenir de chiffre."
                        ]
                    )
                ]
            ])
            ->add('prenom', TextType::class,[
                'required'=>false,
                "constraints" => [
                    new Regex(
                        [
                            "pattern"=>"/\d/",
                            "match"=>false,
                            "message"=>"le prenom ne doit pas contenir de chiffre."
                        ]
                    )
                ]
            ])
            ->add('tel')
            ->add('email',EmailType::class,[
                'required'=>false,
                "constraints" => [
                    new NotNull(),
                    new NotBlank(),
                    new Email([
                        'message'=>'cette email n\'est pas valide'
                    ])
                ]
            ])
            ->add('rgpd', CheckboxType::class, [
                'label'=> false,
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
