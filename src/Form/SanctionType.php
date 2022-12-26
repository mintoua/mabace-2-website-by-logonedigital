<?php

namespace App\Form;

use App\Entity\Sanction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SanctionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type',ChoiceType::class,[
                'choices' => [
                    'Type 1'=>'Type 1',
                    'Type 2'=>'Type 2',
                ]
            ])
            ->add('raison',TextType::class)
            ->add('intitule')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sanction::class,
        ]);
    }
}
