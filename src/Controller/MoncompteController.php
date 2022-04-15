<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoncompteController extends AbstractController
{
    /**
     * @Route("/moncompte", name="moncompte", methods={"GET","POST"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('mail');
        $photo = $request->request->get('photo');

        if (!is_null($nom) && !is_null($prenom) && !is_null($email) && !is_null($photo) ){
            dump($request);
            die();
            /** @var Utilisateur $user */
            $user = $this->getUser();
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setEmail($email);

            $file = $student->getPhoto();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $fileName);
            $student->setPhoto($fileName);

            $entityManager->persist($user);
            $entityManager->flush();
        }



        dump($request->request->get('nom'));
        return $this->render('moncompte/index.html.twig', [
            'controller_name' => 'MoncompteController',
            'actionName'=>'Mon compte'
        ]);
    }
}
