<?php

namespace App\Controller\Parent;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use App\Repository\ParentsRepository;
use App\Repository\ProfesseurRepository;
use App\Repository\PromotionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/parent/eleve")
 */
class EleveController extends AbstractController
{
    /**
     * @Route("/", name="parent_eleve_index", methods={"GET"})
     */
    public function index(EleveRepository $eleveRepository,ParentsRepository $parentsRepository,ProfesseurRepository $professeurRepository,PromotionRepository $promotionRepository): Response
    {
        /**
         * @var Utilisateur
         */
        $utilisateur = $this->getUser();
        $parent = $parentsRepository->findOneBy(array('user'=>$utilisateur));
        $prof = $professeurRepository->findOneBy(array('user'=>$utilisateur));
        $promo = $promotionRepository->findOneBy(array('professeur'=>$prof));
        if(in_array("ROLE_PARENT",$this->getUser()->getRoles())){
            return $this->render('parent/eleve/index.html.twig', [
                'eleves' => $parent->getEleves(),
            ]);
        }
        if(in_array("ROLE_PROF",$this->getUser()->getRoles())){
            return $this->render('parent/eleve/index.html.twig', [
                'eleves' => $promo->getEleves(),
            ]);
        }
        return new Response();
    }

    /**
     * @Route("/new", name="parent_eleve_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eleve = new Eleve();
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eleve);
            $entityManager->flush();

            return $this->redirectToRoute('parent_eleve_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parent/eleve/new.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="parent_eleve_show", methods={"GET"})
     */
    public function show(Eleve $eleve): Response
    {
        return $this->render('parent/eleve/show.html.twig', [
            'eleve' => $eleve,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="parent_eleve_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Eleve $eleve, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('parent_eleve_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parent/eleve/edit.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="parent_eleve_delete", methods={"POST"})
     */
    public function delete(Request $request, Eleve $eleve, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eleve->getId(), $request->request->get('_token'))) {
            $entityManager->remove($eleve);
            $entityManager->flush();
        }

        return $this->redirectToRoute('parent_eleve_index', [], Response::HTTP_SEE_OTHER);
    }
}
