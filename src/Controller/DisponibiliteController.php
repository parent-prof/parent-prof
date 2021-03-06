<?php

namespace App\Controller;

use App\Entity\Disponibilite;
use App\Entity\Professeur;
use App\Form\DisponibiliteType;
use App\Repository\CreneauRepository;
use App\Repository\DisponibiliteRepository;
use App\Repository\ProfesseurRepository;
use App\datetime;
use App\Entity\Creneau;
use DateTime as GlobalDateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/disponibilite")
 */
class DisponibiliteController extends AbstractController
{
    /**
     * @Route("/", name="disponibilite_index",  methods={"GET", "POST"})
     */
    public function index(Request $request,EntityManagerInterface $entityManager, ProfesseurRepository $professeurRepository): Response
    {
        /** @var Professeur $prof */
        $prof = $professeurRepository->findOneBy(array('user'=>$this->getUser()));

        $disponibilite = new Disponibilite();
        $form = $this->createForm(DisponibiliteType::class, $disponibilite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $duree = $request->request->get("duree");
            if ($duree=="15"){
                $disponibilite->setDuree(new \DateTime('00:15:00'));
            } elseif ($duree =="15"){
                $disponibilite->setDuree(new \DateTime('00:30:00'));
            }else{
                $disponibilite->setDuree(new \DateTime('00:45:00'));
            }
            $disponibilite->setProfesseur($prof);
            $entityManager->persist($disponibilite);

            $listeCrenaux = $this->Fractionner1($disponibilite->getHeureDebut()->format("H:i:s"),$disponibilite->getHeureFin()->format("H:i:s"),$disponibilite->getDuree()->format("i"));

            for ($i=0; $i < sizeof($listeCrenaux) -1; $i++) {
                $creneau = new Creneau();
                $creneau->setHeureDebut(new \DateTime($listeCrenaux[$i]));
                $creneau->setHeureFin(new \DateTime($listeCrenaux[$i+1]));
                $creneau->setOccupe(false);
                $creneau->setDisponibilite($disponibilite);
                $entityManager->persist($creneau);
            }
            $entityManager->flush();
            return $this->redirectToRoute('disponibilite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('disponibilite/index.html.twig', [
            'disponibilites' => $prof->getDisponibilites(),
            'actionName'=>"Mes disponibilit??s",
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/new", name="disponibilite_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, ProfesseurRepository $professeurRepository): Response
    {
        $utilisateur = $this->getUser();

        $prof = $professeurRepository->findOneBy(array('user'=>$utilisateur));

        $disponibilite = new Disponibilite();
        $form = $this->createForm(DisponibiliteType::class, $disponibilite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $disponibilite->setProfesseur($prof);
            $entityManager->persist($disponibilite);

            $listeCrenaux = $this->Fractionner1($disponibilite->getHeureDebut()->format("H:i:s"),$disponibilite->getHeureFin()->format("H:i:s"),$disponibilite->getDuree()->format("i"));

            for ($i=0; $i < sizeof($listeCrenaux) -1; $i++) {
                $creneau = new Creneau();
                $creneau->setHeureDebut(new \DateTime($listeCrenaux[$i]));
                $creneau->setHeureFin(new \DateTime($listeCrenaux[$i+1]));
                $creneau->setOccupe(false);
                $creneau->setDisponibilite($disponibilite);
                $entityManager->persist($creneau);
            }
            $entityManager->flush();
            return $this->redirectToRoute('disponibilite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disponibilite/new.html.twig', [
            'disponibilite' => $disponibilite,
            'form' => $form,
            'actionName'=>'Cr??er une disponibilit??'
        ]);
    }

    /**
     * @Route("/{id}", name="disponibilite_show", methods={"GET"})
     */
    public function show(Disponibilite $disponibilite): Response
    {
        return $this->render('disponibilite/show.html.twig', [
            'disponibilite' => $disponibilite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="disponibilite_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Disponibilite $disponibilite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DisponibiliteType::class, $disponibilite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('disponibilite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disponibilite/edit.html.twig', [
            'disponibilite' => $disponibilite,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="disponibilite_delete", methods={"POST"})
     */
    public function delete(Request $request, Disponibilite $disponibilite, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($disponibilite);
        $entityManager->flush();

        return $this->redirectToRoute('disponibilite_index', [], Response::HTTP_SEE_OTHER);
    }

    //
    public function  Fractionner(\DateTime $StartTime, \DateTime $EndTime, \DateTime $Duration): array{

        $ReturnArray = array ();
        $AddMins  =$Duration->getTimestamp();
        $StartTime = $StartTime->getTimestamp();
        $EndTime = $EndTime->getTimestamp();

        while ($StartTime <= $EndTime)
        {
            $ReturnArray[] = date ("G:i", $StartTime);
            $StartTime+= $AddMins;
        }
        dump($ReturnArray);
        return $ReturnArray;
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

    /**
     * @Route("/crenaux/{id}", name="mescrenaux", methods={"GET"})
     */
    public function getCrenaux(Disponibilite $disponibilite, CreneauRepository $creneauRepository): Response
    {
        return $this->render('disponibilite/show.html.twig', [
            'disponibilite' => $disponibilite,
            'actionName'=>'Creneaux du '. $disponibilite->getDateDispo()->format('d-m-Y')
        ]);
    }
}
