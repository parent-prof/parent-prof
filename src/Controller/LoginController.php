<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LoginController extends AbstractController
{
    /**
     * @Route("/api/security/login", name="api-login", methods={"POST"})
     */
    public function index(Request $request): Response
    {
        $username = $request->request->get("username");
        $password = $request->request->get("password");
        if ($username ==="prof"){
            $msg = "prof";
        }else{
            $msg = "parent";
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($msg));

        return $response;
    }
}
