<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoncompteController extends AbstractController
{
    #[Route('/moncompte', name: 'moncompte')]
    public function index(): Response
    {
        return $this->render('moncompte/index.html.twig', [
            'controller_name' => 'MoncompteController',
            'actionName'=>'Mon compte'
        ]);
    }
}
