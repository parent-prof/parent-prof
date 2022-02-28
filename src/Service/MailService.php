<?php
namespace App\Service;


use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class MailService
{
    private $mailer;
    private $nomP;
    private $lien;
    private $date;
    private $nomPa;
    private $heure;


    


    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }
    public function sendEmail(
        string $to = 'tanefodalhia@gmail.com' //email par defaut
        
        
    ): void 
    {
        $email = (new TemplatedEmail())
        //on crée l'email
            ->from('tanefodalhia@gmail.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('hello')
            ->text('Sending emails is fun again!')
            ->htmlTemplate('emails/reunion.html.twig')

            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'foo',
                'nomPa'=>$this->getNomPa(),
                'nomP'=>$this->getNomP(),
                'lien'=>$this->getLien(),
                'date'=>$this->getDate(),
                'heure'=>$this->getHeure(),
            ]);
        $this->mailer->send($email);

        // ...
    }

    public function setNomP($nomP){
        $this->nomP = $nomP;
    }
    public function setLien($lien){
        $this->lien = $lien;
    }
    public function setDate($date){
        $this->date = $date;
    }
    public function setNomPa($nomPa){
        $this->nomPa = $nomPa;
    }
    public function setHeure($heure){
        $this->heure = $heure;
    }

    public function getNomP(){
        return $this->nomP;
    }
    public function getLien(){
        return $this->lien;
    }
    public function getDate(){
        return $this->date;
    }
    public function getHeure(){
        return $this->heure;
    }
    public function getNomPa(){
        return $this->nomPa;
    }
}