<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface as SymfonyMailerInterface;
use Symfony\Component\Mime\Email;

class MailerService implements MailerInterface
{
    private $mailer;
    private $zooEmail;

    public function __construct(SymfonyMailerInterface $mailer, string $zooEmail)
    {
        $this->mailer = $mailer;
        $this->zooEmail = $zooEmail;
    }

    public function sendContactMessage(string $visiteurEmail, string $titre, string $commentaire): void
    {
        $email = (new Email())
            ->from($visiteurEmail)
            ->to($this->zooEmail)
            ->subject($titre)
            ->text("Message:\n$commentaire");

        $this->mailer->send($email);
    }

    public function sendAccountCreationEmail(string $employeEmail, string $username): void
    {
        $email = (new Email())
            ->from($this->zooEmail)
            ->to($employeEmail)
            ->subject("Création de votre compte")
            ->text("Votre compte a été créé avec le nom d'utilisateur: $username. Veuillez contacter votre administrateur pour obtenir votre mot de passe.");

        $this->mailer->send($email);
    }
}