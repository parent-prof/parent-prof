<?php

namespace App\Controller;

use App\Entity\Parents;
use App\Entity\Professeur;
use App\Entity\Reserver;
use App\Entity\ServerSetting;
use App\Entity\Utilisateur;
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
    function encryptLink($date_dispo, $heure_dispo){
        $plain_text =''.date_format($date_dispo, 'Y-m-d')."/".date_format($heure_dispo, 'H:i:s');
        // Store the cipher method
        $ciphering = "AES-128-CTR";
        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        // Non-NULL Initialization Vector for encryption
        $encryption_iv = '1234567891011121';
        // Store the encryption key
        $encryption_key = "parentProf";
        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($plain_text, $ciphering, $encryption_key, $options, $encryption_iv);
        return $encryption;
    }
}
