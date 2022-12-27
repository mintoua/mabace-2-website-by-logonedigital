<?php

namespace App\Form;

use App\Entity\Emprunt;
use DateTimeImmutable;
use Doctrine\DBAL\Types\DateType as TypesDateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type',ChoiceType::class,[
                'choices' => [
                    'Crédit Scolaire' => 'Crédit Scolaire',
                ],
                'empty_data' => 'friend'])
            ->add('montant',MoneyType::class,[
                'currency'=>'XAF'
            ])
            ->add('endedAt',DateType::class,[
                'widget' => 'single_text',
            ])
            ->add('tauxInteret',PercentType::class)
            ->add('tauxInteretDelai',PercentType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
