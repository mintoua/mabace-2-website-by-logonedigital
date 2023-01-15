<?php

namespace App\Form;

use App\Entity\Cycle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class CycleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCycle', TextType::class,[
                "label"=>false,
                "constraints"=>[
                    new NotNull()
                ]
            ])
            ->add('dateDeb', DateType::class,[
                'widget' => 'single_text',
                "constraints"=>[
                    new NotNull()
                ]
            ])
            ->add('dateFin', DateType::class,
            [
                'widget' => 'single_text',
                "constraints"=>[
                    new NotNull()
                ]
            ])
            ->add("commentaire", TextareaType::class,[
                "label"=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cycle::class,
        ]);
    }
}
