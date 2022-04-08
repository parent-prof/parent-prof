<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LogByRoleController extends AbstractController
{
    /**
     * @Route("/", name="log_by_role")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {

        return $this->render('log_by_role/index.html.twig', [
            'controller_name' => 'LogByRoleController',
            'actionName'=>'Login',
        ]);
    }
}
