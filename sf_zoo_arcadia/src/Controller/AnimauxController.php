<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Entity\Animaux;
use App\Entity\Habitats;
use App\Entity\Images;
use App\Entity\Races;
use App\Service\ImageManagerService;
use App\Repository\AnimauxRepository;
use App\Service\AnimauxService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;



#[Route('/api/admin/animaux', name: 'app_api_admin_animaux_')]
class AnimauxController extends AbstractController
{
    private  $animauxService;
    private  $logger; 
    private  $serializer;
    private  $entityManager;
    private $imageManager;

    public function __construct(AnimauxService $animauxService, LoggerInterface $logger,  EntityManagerInterface $entityManager, ImageManagerService $imageManager)
    {
        $this->animauxService = $animauxService;
        $this->logger = $logger;
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders,);
        $this->entityManager = $entityManager;
        $this->imageManager = $imageManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $animaux = $entityManager->getRepository(Animaux::class)->findAll();
        $json = $this->serializer->serialize($animaux, 'json');
        return JsonResponse::fromJsonString($json, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, AnimauxRepository $animauxRepository): Response
    {
        $animal = $animauxRepository->find($id);

        if (!$animal) {
            return $this->json(['error' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($animal, Response::HTTP_OK);
    }

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request): Response
    {
        // Décoder le JSON reçu dans la requête
        $data = json_decode($request->getContent(), true);

        $prenom = $data['prenom'] ?? null;
        $raceId = $data['race'] ?? null;
        $habitatId = $data['habitat'] ?? null;
        $imageId = $data['image'] ?? null; 

        if (!$prenom || !$raceId || !$habitatId) {
            return $this->json(['error' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
        }
        
        try {
            // Charger les entités Race, Habitat et Image depuis la base de données
            $race = $this->entityManager->getRepository(Races::class)->find($raceId);
            $habitat = $this->entityManager->getRepository(Habitats::class)->find($habitatId);

            if (!$race || !$habitat) {
                return $this->json(['error' => 'Invalid race or habitat'], Response::HTTP_BAD_REQUEST);
            }
            $animal = new Animaux();
            $animal->setPrenom($prenom);
            $animal->setRace($race);
            $animal->setHabitats($habitat);
            $animal->setCreatedAt(new \DateTimeImmutable());
             // Gestion de l'image via le service ImageManagerService
            if ($imageId) {
                $image = $this->entityManager->getRepository(Images::class)->find($imageId);
                if (!$image) {
                    return $this->json(['error' => 'Image not found'], Response::HTTP_BAD_REQUEST);
                }
                $animal->setImage($image); // Associer l'image à l'animal
                }
            
            
            // Persister l'animal
            $this->entityManager->persist($animal);
            $this->entityManager->flush();

            return $this->json(['message' => 'Animal created successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Retourner le message de l'exception dans la réponse pour déboguer
            return $this->json([
                'error' => $e -> getMessage(),
                ], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
public function edit(Request $request, int $id, AnimauxRepository $animauxRepository): Response
{
    $animal = $animauxRepository->find($id);
        if (!$animal) {
            return $this->json(['error' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        // Extraire les informations envoyées dans le corps de la requête
        $prenom = $data['prenom'] ?? null;
        $raceId = $data['race'] ?? null;
        $nom = $data['image']['nom'] ?? null;
        $imagePath = $data['image']['imagePath'] ?? null;
        $imageSubDirectory = $data['image']['imageSubDirectory'] ?? null;
        $habitatId = $data['habitats'] ?? null;

        try {
            // Utiliser le service pour mettre à jour l'animal
            $this->animauxService->updateAnimal($animal, $prenom, $raceId, $nom, $imagePath, $imageSubDirectory, $habitatId);

            return $this->json(['message' => 'Animal updated successfully', 'animal' => $animal], Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->json(['error' => 'An error occurred while updating the animal'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteAnimal(int $id, AnimauxRepository $animauxRepository): Response
    {
        
        $animal = $animauxRepository->find($id);
        if (!$animal) {
            return $this->json(['error' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }
    
        try {
            
            $this->animauxService->deleteAnimal($animal);
    
            return $this->json(['message' => 'Animal deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json(['error' => 'An error occurred while deleting the animal'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}