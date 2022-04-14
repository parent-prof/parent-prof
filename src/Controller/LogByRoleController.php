<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogByRoleController extends AbstractController
{
    /**
     * @Route("/", name="log_by_role")
     */
    public function index(): Response
    {
        return $this->render('log_by_role/index.html.twig', [
            'controller_name' => 'LogByRoleController',
            'actionName'=>'LogByRole'
        ]);
    }
}
