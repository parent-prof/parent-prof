<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Reserver;
use App\Entity\Promotion;
use App\Repository\CreneauRepository;
use App\Repository\EleveRepository;
use App\Repository\ParentsRepository;
use App\Repository\ReserverRepository;
use App\Repository\PromotionRepository;
use App\Services\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/apps")
 */
class PrendreRendezVousController extends AbstractController
{
    /**
     * @Route("/rdv/{id}", name="prendre_rdv" ,methods={"GET", "POST"})
     */
    public function index(Eleve $eleve, ParentsRepository  $parentsRepository): Response
    {
        $event = array();
        $form = '<form action="ererc.sf" method="post">';
        $utilisateur = $this->getUser();
        $prof = $eleve->getPromotion()->getProfesseur();
        $parent = $parentsRepository->findOneBy(array('user'=>$utilisateur));
        foreach ($eleve->getPromotion()->getProfesseur()->getDisponibilites() as $disponibilite){
            foreach ($disponibilite->getCreneaux() as $creneau){
                if ($creneau->getOccupe()!=true){
                    array_push($event, array(
                        "startDate"=>$disponibilite->getDateDispo()->format("Y M d"),
                        "endDate"=>$disponibilite->getDateDispo()->format("Y M d"),
                        "summary"=>'<a href="/apps/prendre-rdv?eleve-id='. $eleve->getId() . '&parent-id='.$parent->getId(). '&creneau-id='.$creneau->getId().'" class="custom-switch-description">'. $creneau->getHeureDebut()->format('H:i') .' - '.$creneau->getHeureFin()->format('H:i').  '</a>'
                    ));
                }
            }
        }
        array_push($event, array(
            "startDate"=>$disponibilite->getDateDispo()->format("Y M d"),
            "endDate"=>$disponibilite->getDateDispo()->format("Y M d"),
            "summary"=>'<a class="btn btn-primary">enregistrer</a>'
        ));
        dump($form);
        /*<div class="form-group">
                      <div class="control-label">Toggle switches</div>
                      <div class="custom-switches-stacked mt-2">
                        <label class="custom-switch">
                          <input type="radio" name="option" value="1" class="custom-switch-input" checked="">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Option 1</span>
                        </label>


         $form = $form.'<label class="custom-switch">
                          <input type="radio" name="option" value="1" class="custom-switch-input" checked="">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">'. $creneau->getHeureDebut()->format('H:i') .' - '.$creneau->getHeureFin()->format('H:i').  '</span>
                        </label> <br>';


                        <label class="custom-switch">
                          <input type="radio" name="option" value="2" class="custom-switch-input">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Option 2</span>
                        </label>
                        <label class="custom-switch">
                          <input type="radio" name="option" value="3" class="custom-switch-input">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Option 3</span>
                        </label>
                      </div>
                    </div>*/
        dump(json_encode($event));
        return $this->render('prendre_rendez_vous/index.html.twig', [
            'controller_name' => 'PrendreRendezVousController',
            'event'=>$event,
            'professeur'=>$prof,
            'events'=>json_encode($event)
        ]);
    }

    /**
     * @Route("/api-get-event/{id}", name="api-get-event" ,methods={"GET", "POST"})
     */
    public function getEvents(Eleve $eleve): Response
    {
        $event = array();
        dump($eleve->getPromotion()->getProfesseur());
        foreach ($eleve->getPromotion()->getProfesseur()->getDisponibilites() as $disponibilite){
            array_push($event, array(
                "startDate"=>$disponibilite->getDateDispo()->format("Y M d"),
                "endDate"=>$disponibilite->getDateDispo()->format("Y M d"),
                "summary"=>'bonjour'
            ));
        }
        return new JsonResponse($event);
    }
    /**
     * @Route("/prendre-rdv", name="rdv" ,methods={"GET", "POST"})
     */
    public function getEve(MailService $mail,Request $request, EleveRepository $eleveRepository, ParentsRepository $parentsRepository, CreneauRepository $creneauRepository,PromotionRepository $promotionRepository, ReserverRepository $reserverRepository, EntityManagerInterface $entityManager): Response
    {
        $mail->setNatureMail("prendreRendezVous");
        $eleveId = $request->get('eleve-id');
        $parentId = $request->get('parent-id');
        $creneauId = $request->get('creneau-id');
        $eleve = $eleveRepository->find($eleveId);
        $parent = $parentsRepository->find($parentId);
        $creneau = $creneauRepository->find($creneauId);
        $promotion = $eleve->getPromotion();
        $creneau->setOccupe(true);
        $reserver = new Reserver();
        $reserver->setCreneau($creneau);
        $reserver->setEleve($eleve);
        $reserver->setParent($parent);
        $reserver->setConfirmation(false);
        $entityManager->persist($creneau);
        $entityManager->persist($reserver);
        $entityManager->flush();

        $mail->setNomParent($parent->getUser()->getNom() . ' ' . $parent->getUser()->getPrenom());
        $mail->setNomProf($creneau->getDisponibilite()->getProfesseur()->getUser()->getNom());
        $mail->setHeure($creneau->getHeureDebut()->format('H:i') . '-' . $creneau->getHeureFin()->format('H:i'));
        $mail->setDate($creneau->getDisponibilite()->getDateDispo()->format('Y M d'));
        $mail->setLien("Vous avez une nouvelle reunion");
        $mail->setNomEleve($eleve->getNom());
        $mail->setPromotion($promotion->getNom());
        $mail->sendMail($creneau->getDisponibilite()->getProfesseur()->getUser()->getEmail()); 
        return $this->redirectToRoute('parent_accueil', [], Response::HTTP_SEE_OTHER);

    }
}
