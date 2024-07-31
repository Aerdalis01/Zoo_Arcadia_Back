<?php

namespace App\Entity;

interface MailerInterface
{
    public function sendContactMessage(string $visitorEmail, string $subject, string $message): void;
    public function sendAccountCreationEmail(string $employeEmail, string $username): void;
}
