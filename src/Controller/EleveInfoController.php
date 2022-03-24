<?php

namespace App\Controller;

use App\Entity\Eleve;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EleveInfoController extends AbstractController
{
    
    

     
    /**
     * @Route("eleve/info/{id}",name = "info" , methods={"GET", "POST"})
     */

    public function listerPaPro(Eleve $eleve): Response
    {
        $parents = $eleve -> getParents();
        $promotion = $eleve -> getPromotion();
        return $this->render('eleve_info/index.html.twig', [
            'eleve' => $eleve,
            'parents' => $parents,
            'promotion' => $promotion,
          
            'actionName'=>'eleve'
        ]);
    }

       
}