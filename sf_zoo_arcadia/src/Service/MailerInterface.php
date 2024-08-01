<?php

namespace App\Service;

interface MailerInterface
{
    public function sendContactMessage(string $visiteurEmail, string $titre, string $message): void;
    public function sendAccountCreationEmail(string $employeEmail, string $username): void;
}
