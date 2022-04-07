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
/*
    function encryptLink( $plain_text){
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
    function decryptLink($encryption){
        $ciphering = "AES-128-CTR";
        $decryption_iv = '1234567891011121';
        $options = 0;
        // Store the decryption key
        $decryption_key = "parentProf";
        return openssl_decrypt($encryption, $ciphering,$decryption_key, $options, $decryption_iv);
    }
*/
}
