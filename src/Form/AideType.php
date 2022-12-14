<?php

namespace App\Form;

use App\Entity\Aide;
use App\Entity\CategorieAide;
use Proxies\__CG__\App\Entity\Member;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class AideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule', TextType::class,[
                "label"=>false,
                "constraints"=>[
                    new NotNull()
                ]
            ])
            ->add('description', TextareaType::class,[
                "label"=>false,
            ])
            ->add('categorieAides',EntityType::class, [
                "label"=>false,
                "class"=>CategorieAide::class,
                "constraints"=>[new NotNull()]

            ])
            // ->add('membres', EntityType::class,[
            //     "label"=>false,
            //     "class"=>Member::class,
            //     "multiple" => true,
            //     "constraints"=>[new NotNull()]
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aide::class,
        ]);
    }
}
