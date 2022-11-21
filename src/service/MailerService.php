<?php

namespace App\service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{
    
    public function __construct(private MailerInterface $mailer){
       
    }

    public function sendEmail(
        
        $to="rostandkana2@gmail.com",
        $content='<p>See Twig integration for better HTML integration!</p>',
        $subject='Time for Symfony Mailer!'
    ): void
    {
       
        $email = (new Email())
            ->from('kinfackrostand@gmail.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            // ->replyTo($this->replyTo)
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            // ->text('Sending emails is fun again!')
            ->html($content);

         $this->mailer->send($email);


        // ...
    }
}