<?php

namespace App\Controller;

use App\Entity\Parents;
use App\Entity\Eleve;
use App\Entity\Professeur;
use App\Repository\EleveRepository;
use App\Entity\Reserver;
use App\Entity\ServerSetting;
use App\Entity\Utilisateur;
use App\Repository\ServerSettingRepository;
use App\Services\MailService;
use App\Services\MailParent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
        $mail->setNatureMail("reservation");
        $mail->setNomParent($parent->getNom() . ' ' . $parent->getPrenom());
        $mail->setNomProf($this->getUser()->getNom());
        $mail->setHeure("14h");
        $mail->setDate("05/02/2022");
        $mail->setLien($serverURL->getValue()."?room=". $reserver->getLienReunion() );
        $mail->sendMail($parent->getEmail());
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
     * @Route("/reservation/delete/{id}", name="reservation_delete", methods={"GET","POST"})
     * 
     */
    public function delete(Request $request, Reserver $reserver, MailService $mail, EntityManagerInterface $entityManager): Response
    {
        
        
        $creneau = $reserver->getCreneau();
        $creneau->setOccupe(false);
        $parent = $reserver->getParent()->getUser();
        $prof = $creneau->getDisponibilite()->getProfesseur();
        
        


        $entityManager->remove($reserver);
        $entityManager->persist($creneau);
        $entityManager->flush();

        
        
        $mail->setNatureMail("annulation");
        $mail->setNomParent($parent->getNom() . ' ' . $parent->getPrenom());
        $mail->setNomProf($this->getUser()->getNom());
        $mail->setNomEleve($reserver->getEleve()->getNom());
        $mail->setHeure($creneau->getHeureDebut()->format('H:i'));
        $mail->setDate($creneau->getDisponibilite()->getDateDispo()->format('Y M d'));
        $mail->sendMail($creneau->getDisponibilite()->getProfesseur()->getUser()->getEmail()); 
        



        
        
        return $this->redirectToRoute('parent_accueil', [], Response::HTTP_SEE_OTHER);
        
    }
    
}
