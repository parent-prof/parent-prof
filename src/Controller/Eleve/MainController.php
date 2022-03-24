<?php

namespace App\Controller\Eleve;

use App\Repository\EleveRepository;
use App\Repository\ParentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    public function recupererId(ParentsRepository $parentsRepository): Response
    {
        $parent = $parentsRepository->findOneBy(array('user'=>$this->getUser()));
    }

    /**
     * @Route("/eleve/main", name="eleve_main")
     */
    public function index(EleveRepository $eleveRepository): Response
    {
        return $this->render('eleve/main/index.html.twig', [
            'eleves' => $eleveRepository->findBy([] ,
        ['nom' => 'asc']),//permet d'afficher les elèves sous forme de tableau en ordre asc
        'actionName'=>'eleve'
        ]);
    }
}
