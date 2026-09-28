<?php

namespace App\Form;

use App\Entity\Annee;
use App\Entity\Etudiant;
use App\Entity\NoteAnnee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteAnneeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note')
            ->add('neutralisNoteMini')
            ->add('pointsJury')
            ->add('bonus')
            ->add('remarque')
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => 'id',
            ])
            ->add('annee', EntityType::class, [
                'class' => Annee::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NoteAnnee::class,
        ]);
    }
}
