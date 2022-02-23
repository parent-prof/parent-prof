<?php

namespace App\Form;

use App\Entity\Disponibilite;
use App\Entity\Professeur;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisponibiliteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /**
         * @var Professeur
         */
        $prof = $options['data'];
        $builder
            ->add('heure_fin')
            ->add('date_dispo')
            ->add('heure_debut')
            ->add('duree')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disponibilite::class,
        ]);
    }
}
