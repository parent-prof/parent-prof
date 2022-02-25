<?php

namespace App\Form;

use App\Entity\Disponibilite;
use App\Entity\Professeur;

use App\Entity\Promotion;
use App\Entity\Utilisateur;
use App\Repository\ProfesseurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class DisponibiliteType extends AbstractType
{

    private Utilisateur $professeur;
    private Security $security;
    private ProfesseurRepository $professeurRepository;

    public function __construct(Security $security, ProfesseurRepository $professeurRepository)
    {
        $this->security = $security;
        $this->professeurRepository = $professeurRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /**
         * @var Professeur
         */
        $prof = $options['data'];
        $builder
            ->add('heure_fin')
            ->add('date_dispo', DateTimeType::class,[
                'date_widget'=>'single_text'
            ])
            ->add('heure_debut', TimeType::class)
            ->add('duree')
            ->add('promotion', EntityType::class,[
                'class'=>Promotion::class,
                'choices'=>$this->getPromotion()
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disponibilite::class,
        ]);
    }
    private function getPromotion(): array
    {
        $user = $this->security->getUser();
        /** @var Professeur $prof */
        $prof = $this->professeurRepository->findOneBy(array('user'=>$user));
        return $prof->getPromotions()->toArray();
    }
}
