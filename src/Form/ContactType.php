<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
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
            ->add('email',EmailType::class, [

                "constraints" => [
                    new NotNull(),
                    new NotBlank(),
                    new Email([
                        'message'=>'cette email n\'est pas valide'
                    ])
                ]
            ] )
            ->add('message',TextareaType::class, [
                "constraints" => [
                    new NotNull(),
                    new Length([
                        'min'=>3,
                        "minMessage"=>"minimum {{ limit }} caractères."
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
