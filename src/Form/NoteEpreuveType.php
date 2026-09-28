<?php

namespace App\Form;

use App\Entity\Epreuve;
use App\Entity\Etudiant;
use App\Entity\NoteEpreuve;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteEpreuveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note')
            ->add('neutraliseNoteMini')
            ->add('pointsJury')
            ->add('isDispense')
            ->add('absence')
            ->add('remarque')
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => 'id',
            ])
            ->add('eprueve', EntityType::class, [
                'class' => Epreuve::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NoteEpreuve::class,
        ]);
    }
}
