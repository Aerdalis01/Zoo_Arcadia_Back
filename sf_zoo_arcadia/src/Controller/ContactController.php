<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Service\MailerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{
    private $mailer;
    private $entityManager;

    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }

    public function contactForm(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $visiteurEmail = $request->request->get('email');
            $titre = $request->request->get('titre');
            $commentaire = $request->request->get('commentaire');

          
            $contact = new Contact();
            $contact->setEmail($visiteurEmail);
            $contact->setTitre($titre);
            $contact->setCommentaire($commentaire);

            $this->entityManager->persist($contact);
            $this->entityManager->flush();

            // Envoyer l'email de contact
            $this->mailer->sendContactMessage($visiteurEmail, $titre, $commentaire);

            return new Response('Message envoyé avec succès.');
        }

        return $this->render('contact/form.html.twig');
    }
}
