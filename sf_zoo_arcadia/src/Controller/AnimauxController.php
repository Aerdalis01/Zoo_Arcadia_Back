<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Entity\Animaux;
use App\Form\AnimauxType;
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
    private AnimauxService $animauxService;
    private LoggerInterface $logger; 
    private Serializer $serializer;

    public function __construct(AnimauxService $animauxService, LoggerInterface $logger)
    {
        $this->animauxService = $animauxService;
        $this->logger = $logger;
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders,);
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
        $form = $this->createForm(AnimauxType::class);
        $form->handleRequest($request);
    //dd(json_decode($request->getContent(),true));
        $data = json_decode($request->getContent(),true); 
        $prenom = $data['prenom'];
        $race = $data['race'];
        $nom= $data['image']['nom'];
        $imagePath = $data['image']['imagePath'];
        $imageSubDirectory = $data['image']['imageSubDirectory'];
        $habitat = $data['habitats'];
        

        try {
            $animal = $this->animauxService->createAnimal(
                $prenom,
                $race,
                $nom,
                $imagePath,
                $imageSubDirectory,
                $habitat
            );
            return $this->json(['message' => 'Animal created successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            dd($e);
            $this->logger->error('Error creating animal: ' . $e->getMessage());
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
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