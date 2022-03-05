<?php

namespace App\Controller;

use App\Entity\Parents;
use App\Entity\Professeur;
use App\Entity\Reserver;
use App\Entity\Utilisateur;
use App\Services\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation/{id}", name="confirme_reservation" ,methods={"GET", "POST"})
     */
    public function index(Reserver $reserver, EntityManagerInterface $entityManager, MailService $mail): Response
    {
        $reserver->setConfirmation(true);
        $entityManager->persist($reserver);
        $entityManager->flush();

        /** @var Utilisateur $parent */
        $parent = $reserver->getParent()->getUser();

        $mail->setNomPa($parent->getNom() . ' ' . $parent->getPrenom());
        $mail->setNomP($this->getUser()->getNom());
        $mail->setHeure("14h");
        $mail->setDate("05/02/2022");
        $mail->setLien("www.rdv.fr");
        $mail->sendEmail($parent->getEmail());
        return $this->redirectToRoute('prof_accueil', [], Response::HTTP_SEE_OTHER);
    }
}
