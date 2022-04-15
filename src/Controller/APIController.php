<?php

namespace App\Controller;

use App\Entity\Disponibilite;
use App\Entity\Professeur;
use App\Entity\Promotion;
use App\Entity\Utilisateur;
use App\Form\PromotionType;
use App\Repository\CreneauRepository;
use App\Repository\DisponibiliteRepository;
use App\Repository\EleveRepository;
use App\Repository\ProfesseurRepository;
use App\Repository\PromotionRepository;
use App\Repository\ReserverRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 */
class APIController extends AbstractController
{

    /**
     * @Route("/api-reunion", name="api-reunion", methods={"GET"})
     */
    public function getReunion(Request $request, ProfesseurRepository $professeurRepository,DisponibiliteRepository $disponibiliteRepository, ReserverRepository $reserverRepository, CreneauRepository  $creneauRepository): Response
    {
        $data = $request->get('date');
        $newDate = date("d-m-Y", strtotime($data));


        /** @var Professeur $prof */
        $prof = $professeurRepository->findOneBy(array('user'=>$this->getUser()));
        dump($prof);

        /** @var Disponibilite $disponibilites[] */
        $disponibilites = $prof->getDisponibilites();

        $dispoId = 0;

        /** @var Disponibilite $disponibilite */
        foreach ($disponibilites as $disponibilite){
            $date1 = new \DateTime($newDate);
            $date2 = new \DateTime($disponibilite->getDateDispo()->format("d-m-Y"));
            $result = date_diff($date1,$date2);

            if ($date1 == $date2){
                $dispoId = $disponibilite->getId();
                break;
            }else{
                //$response = $disponibilite->getDateDispo()->format("d-m-Y") . '##'. $newDate;
                $response = "non";
            }
        }


        $disp = $disponibiliteRepository->find($dispoId);
        /** @var Disponibilite $dispos[] */
        $dispos = array();
        array_push($dispos, $disp);



        $reunionsConfirme = $reserverRepository->findMesReunions(true, $creneauRepository->findCrenauxByDisp($dispos));
        $reunions = array();
        foreach ($reunionsConfirme as $item){
            array_push($reunions, array(
                "plage"=>$item->getCreneau()->getHeureDebut()->format('h:i') . ' - ' .$item->getCreneau()->getHeureFin()->format('h:i') ,
                "parent"=>$item->getParent()->getUser()->getNom(). ' '.$item->getParent()->getUser()->getPrenom(),
                "eleve"=>$item->getEleve()->getNom(). ' ' .$item->getEleve()->getNom() ,
                "classe"=>$item->getEleve()->getPromotion()->getNom(),
            ));
        }

        return new JsonResponse($reunions);
    }

    /**
     * @Route("/api-disponibilite", name="api-disponibilite", methods={"GET"})
     */
    public function getDisponibilite(Request $request, ProfesseurRepository $professeurRepository,DisponibiliteRepository $disponibiliteRepository, ReserverRepository $reserverRepository, CreneauRepository  $creneauRepository): Response
    {
        $data = $request->get('mois');
        $moisAnnee = date("m-Y", strtotime('1-'.$data));

        /** @var Professeur $prof */
        $prof = $professeurRepository->findOneBy(array('user'=>$this->getUser()));

        /** @var Disponibilite $disponibilites[] */
        $disponibilites = $prof->getDisponibilites();


        $dateDisponibilite = array();
        /** @var Disponibilite $item */
        foreach ($disponibilites as $item){
            $mois = $item->getDateDispo()->format('m-Y');
            if ($mois== $moisAnnee){
                array_push($dateDisponibilite, array(
                    "date"=>$item->getDateDispo()->format('d-m-Y') ,
                ));
            }
        }
        return new JsonResponse($dateDisponibilite);
    }

}
