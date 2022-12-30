<?php

namespace App\Form;

use App\Entity\Aide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotNull;

class AideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idMembre', TextType::class)
            ->add('typeAide', ChoiceType::class,[
                'choices' => [
                    'aide décès' => 'décès',
                    'aide décès enfant' => 'décès enfant',
                ],
                'constraints' =>[
                    new NotNull()
                ]
            ]) 
            ->add('created_at', DateType::class, [
                'constraints' =>[
                    new NotNull()
                ]
            ])
            ->add('description', TextType::class, [
                'constraints' =>[
                    new NotNull()
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aide::class,
        ]);
    }
}
 