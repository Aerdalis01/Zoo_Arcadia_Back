<?php

namespace App\Controller;

use App\Entity\Habitats;
use Psr\Log\LoggerInterface;
use App\Form\HabitatsType;
use App\Service\HabitatsService;
use App\Repository\HabitatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/api/admin/habitats', name: 'app_api_admin_habitats_')]
class HabitatsController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private HabitatsService $habitatsService;
    private LoggerInterface $logger; 
    

    public function __construct(EntityManagerInterface $entityManager, HabitatsService $habitatsService, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->habitatsService = $habitatsService;
        $this->logger = $logger;
        
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $habitats = $this->entityManager->getRepository(Habitats::class)->findAll();
        
        
        $habitatsArray = [];
        foreach ($habitats as $habitat) {
            $habitatsArray[] = [
                'id' => $habitat->getId(),
                'nom' => $habitat->getNom(),
                'description' => $habitat->getDescription(),
                
            ];
        }

        return $this->json($habitatsArray, Response::HTTP_OK);
    }


    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): Response
    {
        $habitat = $this->entityManager->getRepository(Habitats::class)->find($id);

        if (!$habitat) {
            return $this->json(['error' => 'Habitat not found'], Response::HTTP_NOT_FOUND);
        }
        $data = [
            'id' => $habitat->getId(),
            'nom' => $habitat->getNom(),
            'description' => $habitat->getDescription(),
            
        ];

        
        return $this->json($data, Response::HTTP_OK);

        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

    return $response;
    }


    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request): Response
    {
        $form = $this->createForm(HabitatsType::class);
        $form->handleRequest($request);
    //dd(json_decode($request->getContent(),true));
        $data = json_decode($request->getContent(),true); 
        $nom = $data['nom'];
        $description = $data['description'];
        $nomImage= $data['image']['nom'];
        $imagePath = $data['image']['imagePath'];
        $imageSubDirectory = $data['image']['imageSubDirectory'];
        
        

        try {
            $habitat = $this->habitatsService->createHabitat(
                $nom,
                $description,
                $nomImage,
                $imagePath,
                $imageSubDirectory,
            );
            return $this->json(['message' => 'habitat created successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            dd($e);
            $this->logger->error('Error creating habitat: ' . $e->getMessage());
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    
    }

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
public function edit(Request $request, int $id, HabitatsRepository $habitatsRepository): Response
{
    $habitat = $habitatsRepository->find($id);
        if (!$habitat) {
            return $this->json(['error' => 'Habitat not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        
        $nom = $data['nom'] ?? null;
        $description = $data['description'] ?? null;
        $nomImage = $data['image']['nom'] ?? null;
        $imagePath = $data['image']['imagePath'] ?? null;
        $imageSubDirectory = $data['image']['imageSubDirectory'] ?? null;

        try {
            
            $this->habitatsService->updateHabitat($habitat, $nom, $description, $nomImage, $imagePath, $imageSubDirectory);

            return $this->json(['message' => 'Habitat updated successfully', 'habitat' => $habitat], Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->json(['error' => 'An error occurred while updating the animal'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteAnimal(int $id, HabitatsRepository $habitatsRepository): Response
    {
        $habitat = $habitatsRepository->find($id);
        if (!$habitat) {
            return $this->json(['error' => 'Habitat not found'], Response::HTTP_NOT_FOUND);
        }
    
        try {
            
            $this->habitatsService->deleteHabitat($habitat);
    
            return $this->json(['message' => 'Habitat deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json(['error' => 'An error occurred while deleting the habitat'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}