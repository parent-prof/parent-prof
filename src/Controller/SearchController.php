<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Entity\Promotion;
use App\Entity\Utilisateur;
use App\Form\PromotionType;
use App\Repository\ParentsRepository;
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
     * @Route("/searchProfs", name="search", methods={"GET"})
     */
    public function searchProfs(Request $request, ProfesseurRepository $professeurRepository)
    {
        $target = strtolower($request->query->get('s'));
        $profs = $professeurRepository->findAll();
        $result = array();

        for ($i=0; $i < count($profs); $i++) {
            if(str_contains(strtolower($profs[$i]->getUser()->getNom()),$target) || str_contains(strtolower($profs[$i]->getUser()->getPrenom()),$target)){
                array_push($result, array(
                    'type'=>'Professeur',
                    'nom'=>$profs[$i]->getUser()->getNom(),
                    'prenom'=>$profs[$i]->getUser()->getPrenom(),
                    'path'=>'prof_accueil',
                    'id'=>$profs[$i]->getId()
                ));
            }

        }
        dump($result);
        return $this->render('search/index.html.twig', [
            'allData' => $result,
            'target'=>$target,
            'actionName'=>'Recherche',
            'controller_name'=>'res'
        ]);
    }





     /**
     * @Route("/searchParents", name="searchparents", methods={"GET"})
     */
    public function searchParents(Request $request, ParentsRepository $parentsRepository)
    {
        $target = strtolower($request->query->get('s'));
        $parents = $parentsRepository->findAll();
        $result = array();

        for ($i=0; $i < count($parents); $i++) {
            if(str_contains(strtolower($parents[$i]->getUser()->getNom()),$target) || str_contains(strtolower($parents[$i]->getUser()->getPrenom()),$target)){
                array_push($result, array(
                    'type'=>'Parents',
                    'nom'=>$parents[$i]->getUser()->getNom(),
                    'prenom'=>$parents[$i]->getUser()->getPrenom(),
                    'path'=>'prof_accueil',
                    'id'=>$parents[$i]->getId()
                ));
            }

        }
        dump($result);
        return $this->render('search/index.html.twig', [
            'allData' => $result,
            'target'=>$target,
            'actionName'=>'Recherche',
            'controller_name'=>'res'
        ]);
    }



      /**
     * @Route("/searchPromotion", name="searchpromotion", methods={"GET"})
     */
    public function searchPromotion(Request $request, PromotionRepository $promotionRepository)
    {
        $target = strtolower($request->query->get('s'));
        $promotion = $promotionRepository->findAll();
        $result = array();

        for ($i=0; $i < count($promotion); $i++) {
            if(str_contains(strtolower($promotion[$i]->getNom()),$target) || str_contains(strtolower($promotion[$i]->getProfesseur()->getUser()->getNom()),$target)){
                array_push($result, array(
                    'type'=>'Promotion',
                    'nom'=>$promotion[$i]->getNom(),
                    'prenom'=>$promotion[$i]->getProfesseur()->getUser()->getPrenom(),
                    'path'=>'prof_accueil',
                    'id'=>$promotion[$i]->getId()
                ));
            }

        }
        dump($result);
        return $this->render('search/index.html.twig', [
            'allData' => $result,
            'target'=>$target,
            'actionName'=>'Recherche',
            'controller_name'=>'res'
        ]);
    }

    /**
     * @Route("/search", name="search", methods={"GET"})
     */
   /* public function search(Request $request, ProfesseurRepository $professeurRepository, PromotionRepository $promotionRepository, EleveRepository $eleveRepository )
    {
        $target = strtolower($request->query->get('s'));
        $profs = $professeurRepository->findAll();
        $promo=$promotionRepository->findAll();
        $eleve=$eleveRepository->findAll();
        $result = array();

        for ($i=0; $i < count($profs); $i++) {
            if(str_contains(strtolower($profs[$i]->getUser()->getNom()),$target) || str_contains(strtolower($profs[$i]->getUser()->getPrenom()),$target)){
                array_push($result, array(
                    'type'=>'Professeur',
                    'nom'=>$profs[$i]->getUser()->getNom(),
                    'prenom'=>$profs[$i]->getUser()->getPrenom(),
                    'path'=>'prof_accueil',
                    'id'=>$profs[$i]->getId()
                ));
            }

        }
        for($i=0; $i<count($promo); $i++){
            if(str_contains(strtolower($promo[$i]->getNom()),$target) ){
                array_push($result,
                    array(
                        'type'=>'promotion',
                        'nom'=>$promo[$i]->getNom(),
                        'prenom'=>'',
                        'path'=>'prof_promotion_show',
                        'id'=>$promo[$i]->getId()
                    ));
            }
        }
        for ($i=0; $i < count($eleve); $i++) {
            if(str_contains(strtolower($eleve[$i]->getNom()),$target) || str_contains(strtolower($eleve[$i]->getPrenom()),$target)){
                array_push($result,
                    array(
                        'type'=>'Eleve',
                        'nom'=>$eleve[$i]->getNom(),
                        'prenom'=>$eleve[$i]->getPrenom(),
                        'path'=>'parent_eleve_show',
                        'id'=>$eleve[$i]->getId()
                    ));
            }
        }
        for ($i=0; $i < count($eleve); $i++) {
            if(str_contains(strtolower($eleve[$i]->getClasse()),$target)){
                array_push($result,
                    array(
                        'type'=>'Eleve',
                        'nom'=>$eleve[$i]->get_class(),
                        'path'=>'parent_eleve_show',
                        'id'=>$eleve[$i]->getId()
                    ));
            }
        }
            foreach($result as $k){
                echo $k['type'] ." "."<a href='$k[link]'>$k[data]</a> <br>";
            }
            dump($result);
            return $this->render('search/index.html.twig', [
                'allData' => $result,
                'target'=>$target,
                'actionName'=>'Recherche',
                'controller_name'=>'res'
            ]);
        }*/
}