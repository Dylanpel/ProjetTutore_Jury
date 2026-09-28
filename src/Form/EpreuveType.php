<?php

namespace App\Form;

use App\Entity\Epreuve;
use App\Entity\Nature;
use App\Entity\Ue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EpreuveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero')
            ->add('nom')
            ->add('coefficient')
            ->add('moyenneMinimale')
            ->add('duree')
            ->add('remarque')
            ->add('ue', EntityType::class, [
                'class' => Ue::class,
                'choice_label' => 'id',
            ])
            ->add('nature', EntityType::class, [
                'class' => Nature::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Epreuve::class,
        ]);
    }
}
