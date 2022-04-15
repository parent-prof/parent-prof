<?php
namespace App\Services;


use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class MailService
{
    private $mailer;
    private $nomProf;
    private $lien;
    private $date;
    private $nomParent;
    private $heure;
    private $nomEleve;
    private $promotion;
    private $natureMail;


    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }
public function sendMail($to): void{

if($this->getNatureMail()=="prendreRendezVous"){

    $email = (new TemplatedEmail())
    ->from('tanefodalhia@gmail.com')
    ->to($to)
    ->subject('Confirmation d une réunion')
    ->text('Sending emails is fun again!')
    ->htmlTemplate('emails/invitation.html.twig')

    ->context([
        'nomParent'=>$this->getNomParent(),
        'nomProf'=>$this->getNomProf(),
        'date'=>$this->getDate(),
        'heure'=>$this->getHeure(),
        'nomEleve'=>$this->getNomEleve(),
        'promotion'=>$this->getPromotion(),
    ]);
$this->mailer->send($email);
}

else if($this->getNatureMail()=="reservation"){
    $email = (new TemplatedEmail())
            ->from('tanefodalhia@gmail.com')
            ->to($to)
            ->subject('Invitation à une réunion')
            ->text('Sending emails is fun again!')
            ->htmlTemplate('emails/participation.html.twig')

            ->context([
                'nomParent'=>$this->getNomParent(),
                'nomProf'=>$this->getNomProf(),
                'lien'=>$this->getLien(),
                'date'=>$this->getDate(),
                'heure'=>$this->getHeure(),
            ]);
        $this->mailer->send($email);
}

if($this->getNatureMail()=="annulation"){
    $email = (new TemplatedEmail())
    ->from('tanefodalhia@gmail.com')
    ->to($to)
    ->subject('Annulation d une réunion')
    ->text('Sending emails is fun again!')
    ->htmlTemplate('emails/annulation.html.twig')

    ->context([
        'nomParent'=>$this->getNomParent(),
        'date'=>$this->getDate(),
        'heure'=>$this->getHeure(),
        'nomEleve'=>$this->getNomEleve(),
        'promotion'=>$this->getPromotion(),
    ]);
$this->mailer->send($email);
}

    }

    public function setNomProf($nomProf){
        $this->nomProf = $nomProf;
    }
    public function setLien($lien){
        $this->lien = $lien;
    }
    public function setDate($date){
        $this->date = $date;
    }
    public function setNomParent($nomParent){
        $this->nomParent = $nomParent;
    }
    public function setHeure($heure){
        $this->heure = $heure;
    }
    public function setNatureMail($natureMail){
        $this->natureMail = $natureMail;
    }
    public function setNomEleve($nomEleve){
        $this->nomEleve = $nomEleve;
    }
    public function setPromotion($promotion){
        $this->promotion = $promotion;
    }


    public function getNomProf(){
        return $this->nomProf;
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
    public function getNomParent(){
        return $this->nomParent;
    }
    public function getNatureMail(){
        return $this->natureMail;
    }
    public function getNomEleve(){
        return $this->nomEleve;
    }
    public function getPromotion(){
        return $this->promotion;
    }
}