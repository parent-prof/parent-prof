<?php

namespace App\Controller;

use App\Entity\Parents;
use App\Form\ParentsType;
use App\Repository\ParentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/parents")
 */
class ParentsController extends AbstractController
{
    /**
     * @Route("/", name="parents_index", methods={"GET"})
     */
    public function index(ParentsRepository $parentsRepository): Response
    {
        return $this->render('parents/index.html.twig', [
            'parents' => $parentsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="parents_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parent = new Parents();
        $form = $this->createForm(ParentsType::class, $parent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($parent);
            $entityManager->flush();

            return $this->redirectToRoute('parents_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parents/new.html.twig', [
            'parent' => $parent,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="parents_show", methods={"GET"})
     */
    public function show(Parents $parent): Response
    {
        return $this->render('parents/show.html.twig', [
            'parent' => $parent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="parents_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Parents $parent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParentsType::class, $parent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('parents_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parents/edit.html.twig', [
            'parent' => $parent,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="parents_delete", methods={"POST"})
     */
    public function delete(Request $request, Parents $parent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parent->getId(), $request->request->get('_token'))) {
            $entityManager->remove($parent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('parents_index', [], Response::HTTP_SEE_OTHER);
    }
}
