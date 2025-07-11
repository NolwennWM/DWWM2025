<?php 

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer
{
    public function __construct(private MailerInterface $mailer){}

    public function sendMail(
        string $from = "noreply@cours.fr", 
        string $to = "nolwenn@cours.fr", 
        string $subject = "Message Automatique", 
        string $body = "Ne pas répondre à ce mail")
    {
        $email = new Email();
        $email->from($from)
            ->to($to)
            ->subject($subject)
            ->html($body);
        $this->mailer->send($email);
    }
}