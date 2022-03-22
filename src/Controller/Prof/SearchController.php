<?php

namespace App\Controller\Prof;

use App\Entity\Professeur;
use App\Entity\Promotion;
use App\Entity\Utilisateur;
use App\Form\PromotionType;
use App\Repository\EleveRepository;
use App\Repository\ProfesseurRepository;
use App\Repository\PromotionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 */
class SearchController extends AbstractController
{
    
    /**
    * @Route("/search", name="search", methods={"GET"})
    */
    public function findProfsByName(Request $request, ProfesseurRepository $professeurRepository, PromotionRepository $promotionRepository, EleveRepository $eleveRepository)
    {
        $target = strtolower($request->query->get('s'));


        $profs = $professeurRepository->findAll();
        $promo=$promotionRepository->findAll();
        $eleve=$eleveRepository->findAll();
        $result = array();
    
        for ($i=0; $i < count($profs); $i++) { 
            if(str_contains(strtolower($profs[$i]->getUser()->getNom()),$target) || str_contains(strtolower($profs[$i]->getUser()->getPrenom()),$target)){
                array_push($result, array(
                    'type'=>'prof',
                    'data'=>$profs[$i],
                    'link'=>'google.com'
                ));
            
            } 
            
        }
        for($i=0; $i<count($promo); $i++){
            if(str_contains(strtolower($promo[$i]->getNom()),$target) ){
                array_push($result, 
                array(
                    'type'=>'promotion',
                    'data'=>$promo[$i],
                    'link'=>'google.com'
                ));
        }
    
        for ($i=0; $i < count($eleve); $i++) { 
            if(str_contains(strtolower($eleve[$i]->getNom()),$target) || str_contains(strtolower($eleve[$i]->getPrenom()),$target)){
                array_push($result, 
                array(
                    'type'=>'eleve',
                    'data'=>$eleve[$i],
                    'link'=>'google.com'
                ));
            } 
        }
    foreach($result as $k){
        echo $k['type'] ." "."<a href='$k[link]'>$k[data]</a> <br>";
    } 
        return new Response('');
    }
}
}