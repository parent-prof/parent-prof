<?php

namespace App\Controller\Prof;

use App\Entity\Creneau;
use App\Entity\Disponibilite;
use App\Entity\Professeur;
use App\Entity\Reserver;
use App\Form\DisponibiliteType;
use App\Repository\CreneauRepository;
use App\Repository\DisponibiliteRepository;
use App\Repository\ProfesseurRepository;
use App\Repository\ReserverRepository;
use App\Repository\ServerSettingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="prof_accueil")
     */
    public function index(ReserverRepository $reserverRepository, ProfesseurRepository $professeurRepository, CreneauRepository $creneauRepository, ServerSettingRepository $settingRepository): Response
    {
        /** @var Professeur $prof */
        $prof = $professeurRepository->findOneBy(array('user'=>$this->getUser()));
        dump($prof);

        /** @var Disponibilite $disponibilites[] */
        $disponibilites = $prof->getDisponibilites();

        $reunionsConfirme = $reserverRepository->findMesReunions(true, $creneauRepository->findCrenauxByDisp($disponibilites));

        $reunionsNoConfirme = $reserverRepository->findMesReunions(false, $creneauRepository->findCrenauxByDisp($disponibilites));

        return $this->render('prof/accueil/index.html.twig', [
            'controller_name' => 'Prof',
            'actionName' =>'Accueil',
            'reunionsConfirme'=>$reunionsConfirme,
            'reunionsNoConfirme'=>$reunionsNoConfirme,
            'videoServer'=>$settingRepository->findOneBy(array('name'=>'videoServer'))
        ]);
    }

    function Fractionner1($StartTime, $EndTime, $Duration="60"){

        $ReturnArray = array ();
        $StartTime    = strtotime ($StartTime); // Timestamp
        $EndTime      = strtotime ($EndTime); // Timestamp

        $AddMins  = $Duration * 60;

        while ($StartTime <= $EndTime)
        {
            $ReturnArray[] = date ("G:i", $StartTime);
            $StartTime += $AddMins;
        }
        return $ReturnArray;
    }
}
