<?php

namespace App\Controller\Prof;

use App\Entity\Creneau;
use App\Entity\Disponibilite;
use App\Entity\Professeur;
use App\Entity\Reserver;
use App\Repository\CreneauRepository;
use App\Repository\DisponibiliteRepository;
use App\Repository\ProfesseurRepository;
use App\Repository\ReserverRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="prof_accueil")
     */
    public function index(ReserverRepository $reserverRepository, ProfesseurRepository $professeurRepository, CreneauRepository $creneauRepository): Response
    {
        /** @var Professeur $prof */
        $prof = $professeurRepository->findOneBy(array('user'=>$this->getUser()));

        /** @var Disponibilite $disponibilites[] */
        $disponibilites = $prof->getDisponibilites();

        $reunionsConfirme = $reserverRepository->findMesReunions(true, $creneauRepository->findCrenauxByDisp($disponibilites));
        $reunionsNoConfirme = $reserverRepository->findMesReunions(false, $creneauRepository->findCrenauxByDisp($disponibilites));
        dump($reunionsNoConfirme);
        return $this->render('prof/accueil/index.html.twig', [
            'controller_name' => 'Prof',
            'actionName' =>'Accueil',
            'reunionsConfirme'=>$reunionsConfirme,
            'reunionsNoConfirme'=>$reunionsNoConfirme,
        ]);
    }
}
