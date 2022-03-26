<?php

namespace App\Controller;

use App\Entity\Creneau;
use App\Form\CreneauType;
use App\Repository\CreneauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/creneau')]
class CreneauController extends AbstractController
{
    #[Route('/', name: 'creneau_index', methods: ['GET'])]
    public function index(CreneauRepository $creneauRepository): Response
    {
        return $this->render('creneau/index.html.twig', [
            'creneaus' => $creneauRepository->findAll(),
            'actionName'=>'crenau'
        ]);
    }

    #[Route('/new', name: 'creneau_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $creneau = new Creneau();
        $form = $this->createForm(CreneauType::class, $creneau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($creneau);
            $entityManager->flush();

            return $this->redirectToRoute('creneau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('creneau/new.html.twig', [
            'creneau' => $creneau,
            'form' => $form,
            'actionName'=>'crenau'

        ]);
    }

    #[Route('/{id}', name: 'creneau_show', methods: ['GET'])]
    public function show(Creneau $creneau): Response
    {
        return $this->render('creneau/show.html.twig', [
            'creneau' => $creneau,
            'actionName'=>'crenau'

        ]);
    }

    #[Route('/{id}/edit', name: 'creneau_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Creneau $creneau, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CreneauType::class, $creneau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('creneau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('creneau/edit.html.twig', [
            'creneau' => $creneau,
            'form' => $form,
            'actionName'=>'crenau'

        ]);
    }

    #[Route('/{id}', name: 'creneau_delete', methods: ['POST'])]
    public function delete(Request $request, Creneau $creneau, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$creneau->getId(), $request->request->get('_token'))) {
            $entityManager->remove($creneau);
            $entityManager->flush();
        }

        return $this->redirectToRoute('creneau_index', [], Response::HTTP_SEE_OTHER);
    }
}
