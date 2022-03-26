<?php

namespace App\Controller\Parent;

use App\Repository\EleveRepository;
use App\Repository\ParentsRepository;
use App\Repository\ProfesseurRepository;
use App\Repository\PromotionRepository;
use App\Repository\ReserverRepository;
use App\Repository\ServerSettingRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/apps")
 */
class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="parent_accueil")
     */
    public function index(ReserverRepository $reserverRepository, ServerSettingRepository $settingRepository, ParentsRepository $parentsRepository, ProfesseurRepository $professeurRepository, PromotionRepository $promotionRepository): Response
    {
        /**
         * @var Utilisateur
         */
        $utilisateur = $this->getUser();
        $parent = $parentsRepository->findOneBy(array('user'=>$utilisateur));
        $prof = $professeurRepository->findOneBy(array('user'=>$utilisateur));
        $promo = $promotionRepository->findOneBy(array('professeur'=>$prof));
        $reservations = $reserverRepository->findBy(array('parent'=>$parent));
        if(in_array("ROLE_PARENT",$this->getUser()->getRoles())){
            return $this->render('parent/accueil/index.html.twig', [
                'eleves' => $parent->getEleves(),
                'reservations'=>$reservations,
                'videoServer'=>$settingRepository->findOneBy(array('name'=>'videoServer')),
            ]);
        }
        if(in_array("ROLE_PROF",$this->getUser()->getRoles())){
            return $this->render('parent/eleve/index.html.twig', [
                'eleves' => $promo->getEleves(),
            ]);
        }
        return new Response();
    }

}
