<?php

namespace App\Form;

use App\Entity\Calcul;
use App\Entity\Ue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('nom_court')
            ->add('ects')
            ->add('moyenne_validation')
            ->add('moyenne_minimale')
            ->add('code_apogee')
            ->add('code_ose')
            ->add('remarque')
            ->add('calcul', EntityType::class, [
                'class' => Calcul::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ue::class,
        ]);
    }
}
