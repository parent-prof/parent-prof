<?php

namespace App\Controller\Prof;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="prof_accueil")
     */
    public function index(): Response
    {
        return $this->render('prof/accueil/index.html.twig', [
            'controller_name' => 'Prof',
        ]);
    }
}
