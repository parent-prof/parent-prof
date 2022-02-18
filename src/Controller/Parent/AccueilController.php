<?php

namespace App\Controller\Parent;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="parent_accueil")
     */
    public function index(): Response
    {
        return $this->render('parent/accueil/index.html.twig', [
            'controller_name' => 'Parent',
        ]);
    }
}
