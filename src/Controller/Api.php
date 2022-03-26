<?php

namespace App\Controller;

use App\Entity\Eleve;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Api extends AbstractController
{
    /**
     * @Route("/api-get-event/{id}", name="api-get-event" ,methods={"GET", "POST"})
     */
    public function getEvents(Eleve $eleve): Response
    {
        $event = array();
        dump($eleve->getPromotion()->getProfesseur());
        foreach ($eleve->getPromotion()->getProfesseur()->getDisponibilites() as $disponibilite){
            array_push($event, array(
                "startDate"=>$disponibilite->getDateDispo()->format("Y M d"),
                "endDate"=>$disponibilite->getDateDispo()->format("Y M d"),
                "summary"=>'bonjour'
            ));
        }
        return new JsonResponse($event);
    }
}
