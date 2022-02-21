<?php

namespace App\Controller;

use App\Entity\Disponibilite;
use App\Form\DisponibiliteType;
use App\Repository\DisponibiliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/disponibilite")
 */
class DisponibiliteController extends AbstractController
{
    /**
     * @Route("/", name="disponibilite_index", methods={"GET"})
     */
    public function index(DisponibiliteRepository $disponibiliteRepository): Response
    {
        return $this->render('disponibilite/index.html.twig', [
            'disponibilites' => $disponibiliteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="disponibilite_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $disponibilite = new Disponibilite();
        $form = $this->createForm(DisponibiliteType::class, $disponibilite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($disponibilite);
            $entityManager->flush();

            return $this->redirectToRoute('disponibilite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disponibilite/new.html.twig', [
            'disponibilite' => $disponibilite,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="disponibilite_show", methods={"GET"})
     */
    public function show(Disponibilite $disponibilite): Response
    {
        return $this->render('disponibilite/show.html.twig', [
            'disponibilite' => $disponibilite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="disponibilite_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Disponibilite $disponibilite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DisponibiliteType::class, $disponibilite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('disponibilite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disponibilite/edit.html.twig', [
            'disponibilite' => $disponibilite,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="disponibilite_delete", methods={"POST"})
     */
    public function delete(Request $request, Disponibilite $disponibilite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$disponibilite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($disponibilite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('disponibilite_index', [], Response::HTTP_SEE_OTHER);
    }
}
