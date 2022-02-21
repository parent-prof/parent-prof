<?php

namespace App\Form;

use App\Entity\Reserver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReserverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('H_debut')
            ->add('H_fin')
            ->add('confirmation')
            ->add('id_parent')
            ->add('heure_fin')
            ->add('Date_dispo')
            ->add('Heure_debut')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reserver::class,
        ]);
    }
}
