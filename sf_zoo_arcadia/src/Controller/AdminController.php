<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Veterinaire;
use App\Entity\Admin;
use App\Service\MailerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{
    private $mailer;
    private $entityManager;

    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }

    public function createUser(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $role = $request->request->get('role'); // employe, veterinaire, ou admin

            if ($role === 'employe') {
                $user = new Employe();
            } elseif ($role === 'veterinaire') {
                $user = new Veterinaire();
            } elseif ($role === 'admin') {
                $user = new Admin();
            } else {
                return new Response('Rôle invalide.', 400);
            }

            $user->setEmail($email ? $email : null);
            $user->setUsername($email);
            $user->setPassword('password');
            $user->setCreatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            if ($email) {
                $this->mailer->sendAccountCreationEmail($email, $email);
            }

            return new Response('Compte créé avec succès' . ($email ? ' et email envoyé.' : '.'));
        }

        return $this->render('admin/create_user.html.twig');
    }
}