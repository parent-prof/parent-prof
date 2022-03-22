<?php

namespace App\Controller\Prof;

use App\Entity\Professeur;
use App\Entity\Promotion;
use App\Entity\Utilisateur;
use App\Form\PromotionType;
use App\Repository\ProfesseurRepository;
use App\Repository\PromotionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/prof/promotion")
 */
class PromotionController extends AbstractController
{
    
    /**
     * @Route("/", name="prof_promotion_index", methods={"GET"})
     */

    public function index(PromotionRepository $promotionRepository, ProfesseurRepository $professeurRepository): Response
    {
        /**
         * @var Utilisateur
        */
        $utilisateur = $this->getUser();

        $prof = $professeurRepository->findOneBy(array('user'=>$utilisateur));

        return $this->render('prof/promotion/index.html.twig', [
            'promotions' => $prof->getPromotions(),
            'actionName' =>'Promotions'
        ]);
    }
    /**
    * @Route("/allprofs", name="allprofs", methods={"GET"})
    */
    public function findProfsByPromotion( ProfesseurRepository $professeurRepository)
    {
        
        $profs = $professeurRepository->findAll();
        $profsByPromo = array_filter($profs, function($prof){
            return $prof->getPromotion()->getId() === "1";
        });
        $str = "";
        for ($i=0; $i < count($profsByPromo); $i++) { 
          $str .= $profsByPromo[$i]->getPromotions()->getIterator()."<br>";  
        }
        return new Response($str);
    }

    /**
     * @Route("/new", name="prof_promotion_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($promotion);
            $entityManager->flush();

            return $this->redirectToRoute('prof_promotion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prof/promotion/new.html.twig', [
            'promotion' => $promotion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="prof_promotion_show", methods={"GET"})
     */
    public function show(Promotion $promotion): Response
    {
        return $this->render('prof/promotion/show.html.twig', [
            'promotion' => $promotion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prof_promotion_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Promotion $promotion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('prof_promotion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prof/promotion/edit.html.twig', [
            'promotion' => $promotion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="prof_promotion_delete", methods={"POST"})
     */
    public function delete(Request $request, Promotion $promotion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promotion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($promotion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prof_promotion_index', [], Response::HTTP_SEE_OTHER);
    }
}
