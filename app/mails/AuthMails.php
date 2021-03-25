<?php


namespace App\mails;


use Application\Mails\MailSender;

class AuthMails extends MailSender
{


    public function __construct()
    {
        parent::__construct();
        $this->setSmtp("MAILDEV");
    }



    public function sendApplicationConfigMail($email,$name,$url){
        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($this->getTransport());

        // Create a message
        $message =  (new \Swift_Message("Application configurer avec success"))
            ->setFrom( $this->addresses )
            ->setTo([$email => $name])
            ->setBody("Application Configurée avec success.<br>
               <a href='$url'>Terminer la création du compte</a> / $url ",'text/html')
            ->setCharset('UTF-8');

        $mailer->send($message);
    }


    public function sendUserCreationMail($email,$name,$url){
        $mailer = new \Swift_Mailer(  $this->getTransport() );

        // Create a message
        $message =  (new \Swift_Message("Votre compte a ete creeer avec success"))
            ->setFrom($this->addresses)
            ->setTo([$email => $name])
            ->setBody("Cretion de votre compte sur {$this->app_name}.<br> 
                Confirmer votre compte a cette addresse <hr>
               <a href='$url'>Terminer la création du compte</a> / $url ",'text/html')
            ->setCharset('UTF-8');

        $mailer->send($message);
    }

    public function sendPasswordResetMail($email,$name,$url){
        $mailer = new \Swift_Mailer($this->getTransport());
        $message =  (new \Swift_Message("Reinitialisation de mot de passe"))
            ->setFrom($this->addresses)
            ->setTo([$email => $name])
            ->setBody("Reinitialisation de mot de passe sur {$this->app_name}.<hr> 
                Reinitialisation de mot de passe a cette addresse <hr>
               <a href='$url'>Reinitialisation de mot de passe</a> / $url ",'text/html');
        $mailer->send($message);
    }



}