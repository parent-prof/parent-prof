<?php

namespace App\Controller;

use App\Repository\ParentsRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    public function index(Request $request, UtilisateurRepository $userRep): Response
    {
        $username = $request->query->get("email");
        $password = $request->query->get("mdp");
        $user=$userRep->findOneBySomeField($username, $password);
        $role=$user->getRoles();
        if ($roles ="ROLES_PARENT") {
            
            return $this->redirectToRoute('parents_index', [], Response::HTTP_SEE_OTHER);
        }
        else {
            return $this->redirectToRoute('api-login',[],Response::HTTP_SEE_OTHER);
        }

    }
}

