<?php

namespace App\Controller;

use App\Entity\Parents;
use App\Entity\Professeur;
use App\Entity\Reserver;
use App\Entity\ServerSetting;
use App\Entity\Utilisateur;
use App\Repository\ParentsRepository;
use App\Repository\ReserverRepository;
use App\Repository\ServerSettingRepository;
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
    public function index(Reserver $reserver, EntityManagerInterface $entityManager, MailService $mail, ServerSettingRepository $settingRepository): Response
    {
        $reserver->setConfirmation(true);
        $reserver->setLienReunion($this->getRandomRoomId());
        $entityManager->persist($reserver);
        $entityManager->flush();

        /** @var ServerSetting $serverURL */
        $serverURL = $settingRepository->findOneBy(array('name'=>'videoServer'));

        /** @var Utilisateur $parent */
        $parent = $reserver->getParent()->getUser();

        $mail->setNomPa($parent->getNom() . ' ' . $parent->getPrenom());
        $mail->setNomP($this->getUser()->getNom());
        $mail->setHeure("14h");
        $mail->setDate("05/02/2022");
        $mail->setLien($serverURL->getValue()."?room=". $reserver->getLienReunion() );
        $mail->sendEmail($parent->getEmail());
        return $this->redirectToRoute('prof_accueil', [], Response::HTTP_SEE_OTHER);
    }
    function getRandomRoomId($length = 50) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

    /**
     * @Route("parent/reservation", name="mes_reservations" ,methods={"GET", "POST"})
     */
    public function showReservation(ReserverRepository $reserverRepository , ParentsRepository $parentRepository, EntityManagerInterface $entityManager)
    {
        $parent = $parentRepository->findOneBy(array('user'=>$this->getUser()));
        $liste_rdv =$reserverRepository->findByIdParent($parent);

        return $this->render('reservation/index.html.twig', [
            'mes_reunions' => $liste_rdv,
            'actionName'=>"Mes reunions",
        ]);
    }
}
