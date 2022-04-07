<?php

namespace App\Controller;

use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoCheckController extends AbstractController
{
    /**
     * @Route("/video", name="video_check")
     */
    public function index(Request $request): Response
    {
        $timezone = new DateTimeZone ('Europe/Paris');

        $encode = explode('room=',$request->getRequestUri());
        $encryption= $encode[1];
        $decryption= explode('/', $this->decryptLink($encryption));
        $date= date('Y-m-d',strtotime($decryption[0]));
        $heure_debut = date_format(date_create($decryption[1],$timezone),'H:i:s');
        if($date>=date('Y-m-d')){
            if($heure_debut >date_format((new \DateTime('now'))->setTimezone($timezone), 'H:i:s')){
                echo 'bon!';
            }
        }
        else{
            echo 'mauvais!';
        }
        die();
    }
    function decryptLink($encryption){
        $ciphering = "AES-128-CTR";
        $decryption_iv = '1234567891011121';
        $options = 0;
        // Store the decryption key
        $decryption_key = "parentProf";
        return openssl_decrypt($encryption, $ciphering,$decryption_key, $options, $decryption_iv);
    }
}
