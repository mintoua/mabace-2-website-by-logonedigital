<?php

namespace App\Form;

use App\Entity\CalendrierBenef;
use App\Entity\Cycle;
use App\Entity\Member;
use App\Entity\Tontine;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class BenefsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateBenef',DateType::class,[
                'widget' => 'single_text',
                
            ])
            ->add('tontine',EntityType::class,[
                'class'=>Tontine::class,
                
            ])
            ->add('membre',EntityType::class,[
                'class'=>Member::class,
            ])
            ->add('rang',TextType::class,[
                "constraints"=>[
                    new NotNull()
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CalendrierBenef::class,
        ]);
    }
}
