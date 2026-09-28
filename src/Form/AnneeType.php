<?php

namespace App\Form;

use App\Entity\Annee;
use App\Entity\Parcour;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnneeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('an')
            ->add('nom')
            ->add('nomCourt')
            ->add('isCompensable')
            ->add('moyenneValidation')
            ->add('remarque')
            ->add('parcour', EntityType::class, [
                'class' => Parcour::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annee::class,
        ]);
    }
}
