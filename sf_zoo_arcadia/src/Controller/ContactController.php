<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Service\MailerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/api/contact', name: '_app_api_contact_')]
class ContactController extends AbstractController
{
    private $mailer;
    private $entityManager;

    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }
    #[Route('/new', name: 'new', methods: ['POST'])]
    public function contactForm(Request $request): Response
    {
        // Décoder les données JSON de la requête
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'Invalid JSON data'], Response::HTTP_BAD_REQUEST);
        }

        // Vérifier que les champs requis sont présents
        if (!isset($data['email'], $data['titre'], $data['commentaire'])) {
            return $this->json(['error' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
        }

        // Créer un nouvel objet Contact et remplir ses propriétés
        $contact = new Contact();
        $contact->setEmail($data['email']);
        $contact->setTitre($data['titre']);
        $contact->setCommentaire($data['commentaire']);

        // Persister le contact en base de données
        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        // Envoyer l'email de contact
        $this->mailer->sendContactMessage($data['email'], $data['titre'], $data['commentaire']);

        // Retourner une réponse de succès
        return $this->json(['message' => 'Contact created and email sent successfully'], Response::HTTP_CREATED);
    }
}

