<?php

namespace App\Form;

use App\Entity\Division;
use App\Entity\Etudiant;
use App\Entity\NoteDivision;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteDivisionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note')
            ->add('neutraliseNoteMini')
            ->add('pointsJury')
            ->add('isDispense')
            ->add('remarque')
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => 'id',
            ])
            ->add('division', EntityType::class, [
                'class' => Division::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NoteDivision::class,
        ]);
    }
}
