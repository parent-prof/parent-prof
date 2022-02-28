<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;
use App\Service\MailService;


class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request , MailService $mail )//MailerInterface $mailer)

    {
        $form=$this->createForm(ContactType::class);
        $form->handleRequest($request);
       // $contact = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $mail->setNomPa("Rudolph");
            $mail->setNomP("Fethi");
            $mail->setHeure("14h");
            $mail->setDate("05/02/2022");
            $mail->setLien("www.rdv.fr");

          
        $mail->sendEmail('tanefodalhia@gmail.com');
               
           

            $this->addFlash('message' , 'Le message a bien été envoyé');
            //return $this->redirectToRoute('accueil');

        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}
