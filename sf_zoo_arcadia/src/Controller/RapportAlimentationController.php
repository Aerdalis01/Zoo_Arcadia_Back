<?php

namespace App\Controller;

use App\Entity\RapportAlimentation;
use App\Form\RapportAlimentationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\AnimauxRepository;
#[Route('/api/rapport-alimentation', name: 'app_api_rapport_alimentation_')]
class RapportAlimentationController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
public function index(EntityManagerInterface $entityManager): JsonResponse
{
    // Récupérer tous les rapports d'alimentation
    $rapports = $entityManager->getRepository(RapportAlimentation::class)->findAll();

    // Serializer tous les rapports pour renvoyer sous forme JSON
    $data = [];
    foreach ($rapports as $rapport) {
        $data[] = [
            'id' => $rapport->getId(),
            'date' => $rapport->getDate()->format('Y-m-d'),
            'heure' => $rapport->getHeure()->format('H:i:s'),
            'nourriture' => $rapport->getNourriture(),
            'quantite' => $rapport->getQuantite(),
            'employe' => $rapport->getEmploye()->getUsername(),
            'animal' => $rapport->getAnimal()->getPrenom(),
            'createdAt' => $rapport->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    return new JsonResponse($data, JsonResponse::HTTP_OK);
}


    #[Route('/new', name: 'new', methods: ['POST'])]
    public function createRapport(Request $request, 
    EntityManagerInterface $entityManager, 
    UserRepository $userRepository, 
    AnimauxRepository $animauxRepository
): JsonResponse {
    $data = json_decode($request->getContent(), true);

    if (!$data) {
        return new JsonResponse(['error' => 'Aucune donnée reçue'], JsonResponse::HTTP_BAD_REQUEST);
    }
    $employe = $userRepository->findOneBy(['username' => $data['username']]);
    if (!$employe) {
        return new JsonResponse(['error' => 'Employé non trouvé'], JsonResponse::HTTP_BAD_REQUEST);
    }
    $animal = $animauxRepository->findOneBy(['prenom' => $data['prenom']]);
    if (!$animal) {
        return new JsonResponse(['error' => 'Animal non trouvé'], JsonResponse::HTTP_BAD_REQUEST);
    }

    // Supprimer les clés 'username' et 'prenom' car elles ne sont pas nécessaires pour le formulaire
    unset($data['username'], $data['prenom']);

    $rapport = new RapportAlimentation();
    $form = $this->createForm(RapportAlimentationType::class, $rapport);
    
    // Utilisez `submit` pour envoyer directement les données JSON dans le formulaire
    $form->submit($data);

     // Vérifier si le formulaire est soumis et valide
    if ($form->isSubmitted() && !$form->isValid()) {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return new JsonResponse(['error' => 'Données invalides', 'details' => $errors], JsonResponse::HTTP_BAD_REQUEST);
    }

    if ($form->isSubmitted() && $form->isValid()) {
        // Ajouter l'employé et l'animal au rapport
        $rapport->setEmploye($employe);
        $rapport->setAnimal($animal);
        $rapport->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($rapport);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Rapport créé avec succès'], JsonResponse::HTTP_OK);
    }

    // Renvoyer les erreurs de validation si elles existent
    return new JsonResponse(['error' => 'Données invalides ou formulaire non soumis'], JsonResponse::HTTP_BAD_REQUEST);
}

#[Route('/{id}', name: 'update', methods: ['PUT'])]
public function update(
    int $id, 
    Request $request, 
    EntityManagerInterface $entityManager, 
    UserRepository $userRepository, 
    AnimauxRepository $animauxRepository
): JsonResponse {
    // Récupérer le rapport d'alimentation par son ID
    $rapport = $entityManager->getRepository(RapportAlimentation::class)->find($id);

    if (!$rapport) {
        return new JsonResponse(['error' => 'Rapport non trouvé'], JsonResponse::HTTP_NOT_FOUND);
    }

    // Décoder les données JSON envoyées dans la requête
    $data = json_decode($request->getContent(), true);

    if (!$data) {
        return new JsonResponse(['error' => 'Aucune donnée reçue'], JsonResponse::HTTP_BAD_REQUEST);
    }

    // Rechercher l'employé par username dans le UserRepository
    if (isset($data['username'])) {
        $employe = $userRepository->findOneBy(['username' => $data['username']]);
        if (!$employe) {
            return new JsonResponse(['error' => 'Employé non trouvé'], JsonResponse::HTTP_BAD_REQUEST);
        }
        $rapport->setEmploye($employe);
    }

    // Rechercher l'animal par prenom dans AnimauxRepository
    if (isset($data['prenom'])) {
        $animal = $animauxRepository->findOneBy(['prenom' => $data['prenom']]);
        if (!$animal) {
            return new JsonResponse(['error' => 'Animal non trouvé'], JsonResponse::HTTP_BAD_REQUEST);
        }
        $rapport->setAnimal($animal);
    }

    // Soumettre le formulaire pour mettre à jour les autres champs
    unset($data['username'], $data['prenom']); // On enlève les champs non liés directement au formulaire
    $form = $this->createForm(RapportAlimentationType::class, $rapport);
    $form->submit($data, false);  // 'false' permet de ne pas effacer les données manquantes

    if ($form->isSubmitted() && !$form->isValid()) {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return new JsonResponse(['error' => 'Données invalides', 'details' => $errors], JsonResponse::HTTP_BAD_REQUEST);
    }

    // Mettre à jour le rapport dans la base de données
    $rapport->setUpdatedAt(new \DateTimeImmutable()); // Mettre à jour la date de modification
    $entityManager->flush();

    return new JsonResponse(['message' => 'Rapport mis à jour avec succès'], JsonResponse::HTTP_OK);
}
}
