<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesCreneauxController extends AbstractController
{
    /**
     * @Route("/crendsfsfs", name="disponibilsite_index",  methods={"GET", "POST"})
     */
    public function index(): Response
    {
        return $this->render('mes_creneaux/index.html.twig', [
            'controller_name' => 'MesCreneauxController',
        ]);
    }
}
