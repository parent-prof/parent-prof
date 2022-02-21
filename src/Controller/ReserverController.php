<?php

namespace App\Controller;

use App\Entity\Reserver;
use App\Form\ReserverType;
use App\Repository\ReserverRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reserver")
 */
class ReserverController extends AbstractController
{
    /**
     * @Route("/", name="reserver_index", methods={"GET"})
     */
    public function index(ReserverRepository $reserverRepository): Response
    {
        return $this->render('reserver/index.html.twig', [
            'reservers' => $reserverRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reserver_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reserver = new Reserver();
        $form = $this->createForm(ReserverType::class, $reserver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reserver);
            $entityManager->flush();

            return $this->redirectToRoute('reserver_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reserver/new.html.twig', [
            'reserver' => $reserver,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="reserver_show", methods={"GET"})
     */
    public function show(Reserver $reserver): Response
    {
        return $this->render('reserver/show.html.twig', [
            'reserver' => $reserver,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reserver_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reserver $reserver, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReserverType::class, $reserver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('reserver_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reserver/edit.html.twig', [
            'reserver' => $reserver,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="reserver_delete", methods={"POST"})
     */
    public function delete(Request $request, Reserver $reserver, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reserver->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reserver);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reserver_index', [], Response::HTTP_SEE_OTHER);
    }
    // Appel de la methode de l'affichage 
    /**
     * @Route("/Reservations/", name="reservation_show", methods={"GET"})
     */
    public function showReservation(ReserverRepository $reserver): Response
    {
        $reserver->findByIdParent($this->getUser())

        //dd($reservations);
             // return $this->render('reserver/show.html.twig', [
            //'reserver' => $reservations,
       // ]);
    }


}
