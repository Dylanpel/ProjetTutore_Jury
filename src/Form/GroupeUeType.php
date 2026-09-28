<?php

namespace App\Form;

use App\Entity\Groupe;
use App\Entity\GroupeUe;
use App\Entity\Ue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupeUeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('remarque')
            ->add('groupe', EntityType::class, [
                'class' => Groupe::class,
                'choice_label' => 'id',
            ])
            ->add('ue', EntityType::class, [
                'class' => Ue::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GroupeUe::class,
        ]);
    }
}
