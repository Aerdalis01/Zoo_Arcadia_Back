<?php

namespace App\Service;

use App\Entity\MailerInterface;

class MailerService implements MailerInterface
{
    private $zooEmail;

    public function __construct(string $zooEmail)
    {
        $this->zooEmail = $zooEmail;
    }

    public function sendContactMessage(string $visiteurEmail, string $titre, string $commentaire): void
    {
        $to = $this->zooEmail;
        $body = "Email: $visiteurEmail\n\nMessage:\n$commentaire";
        mail($to, $titre, $body);
    }

    public function sendAccountCreationEmail(string $employeEmail, string $username): void
    {
        $titre = "Création de votre compte";
        $body = "Votre compte a été créé avec le nom d'utilisateur: $username. Veuillez contacter votre administrateur pour obtenir votre mot de passe.";
        mail($employeEmail, $titre, $body);
    }
}