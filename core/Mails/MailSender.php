<?php

namespace Application\Mails;

class MailSender{

    protected $app_name;
    protected $addresses ;
    private $transport;
    private $smtp = null;

    /**
     * @param string $smtp
     */
    public function setSmtp(string  $smtp): void
    {
        $this->smtp = $smtp;
    }


    /**
     * @return \Swift_SmtpTransport
     */
    public function getTransport(): \Swift_SmtpTransport
    {
        return $this->transport;
    }


    public function __construct()
    {
        $this->app_name = app_config("APP_NAME");
        $config = app_config('MAIL_CONFIG');
        $this->smtp = $config;
        $host = $config['MAIL_HOST'];
        $port = $config['MAIL_PORT'];
        $username = $config['MAIL_USERNAME'] ?? null ;
        $password = $config['MAIL_PASSWORD'] ?? null;
        $mail_encrypt = $config['MAIL_ENCRYPT'] ?? null;
        $this->addresses = [
            $config['MAIL_USERNAME'] =>  $config['MAIL_FROM_NAME'] ?? "Espace Memebre PHP "
        ];
        if ( !empty($username)  AND !empty($password) AND !empty($password) )
        {
            $this->transport = (new \Swift_SmtpTransport())
                ->setHost($host)
                ->setPort($port)
                ->setEncryption($mail_encrypt)
                ->setUsername($username)
                ->setPassword($password);
        }else{
            $this->transport = (new \Swift_SmtpTransport())
                ->setHost($host)
                ->setPort($port);
        }



    }

    public static function Instance(){
        return new static();
    }


    public function testEmail($email,$name){
        $mailer = new \Swift_Mailer($this->getTransport());
        $message =  (new \Swift_Message("Email de test"))
            ->setFrom($this->addresses)
            ->setTo([$email => $name])
            ->setBody("Email de test<hr>Email envoyer par mailgun <hr>",'text/html');
        $mailer->send($message);
    }



}
