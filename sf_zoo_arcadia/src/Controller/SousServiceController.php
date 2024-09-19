<?php

namespace App\Controller;


use App\Entity\Services;
use App\Entity\SousService;
use App\Repository\SousServiceRepository;
use App\Service\SousServiceService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/SousService', name: 'app_api_sous_service_')]
class SousServiceController extends AbstractController
{
    private SousServiceService $sousServiceService;
    private EntityManagerInterface $entityManager;

    public function __construct(SousServiceService $sousServiceService, EntityManagerInterface $entityManager)
    {
        $this->sousServiceService = $sousServiceService;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $sousService = $entityManager->getRepository(SousService::class)->findAll();
        $data = $serializer->serialize($sousService, 'json', ['groups' => 'Sous_service_basic']);
        return new JsonResponse(json_decode($data), JsonResponse::HTTP_OK);
    }
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $sousService = $entityManager->getRepository(SousService::class)->find($id);
        $data = $serializer->serialize($sousService, 'json', ['groups' => 'sous_services_basic']);
        return new JsonResponse(json_decode($data), JsonResponse::HTTP_OK);
    }

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function createSousService(Request $request): JsonResponse
    {
        // Décodage des données de la requête
        $data = json_decode($request->getContent(), true);

        // Vérification si le type est fourni dans les données
        if (!isset($data['type'])) {
            return new JsonResponse(['status' => 'error', 'message' => 'Type de sous-service manquant'], 400);
        }

        try {
            // Appeler le service pour créer ou mettre à jour un sous-service
            $sousService = $this->sousServiceService->createOrUpdateSousService(null, $data);

            // Retourner une réponse JSON avec succès
            return new JsonResponse(['status' => 'success', 'id' => $sousService->getId()], 201);

        } catch (\InvalidArgumentException $e) {
            // En cas d'argument invalide
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            // En cas d'autre exception
            return new JsonResponse(['status' => 'error', 'message' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
        }
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function updateService(int $id,Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $sousService = $this->entityManager->getRepository(SousService::class)->find($id);

        if (!$sousService) {
            $service = $this->entityManager->getRepository(Services::class)->find($id);
            if (!$service) {
                return new JsonResponse(['status' => 'error', 'message' => 'Service ou SousService non trouvé'], 404);
            }
        }
        try {
            if ($sousService) {
                
                $this->sousServiceService->createOrUpdateSousService($sousService, $data);
                return new JsonResponse(['status' => 'success', 'id' => $sousService->getId()], 200);
            } else {
                
                $this->sousServiceService->createOrUpdateSousService($service, $data);
                return new JsonResponse(['status' => 'success', 'id' => $service->getId()], 200);
            }

        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
        }
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, SousServiceRepository $sousServiceRepository): Response
    {
        $sousService = $sousServiceRepository->find($id);
        
        if (!$sousService) {
            return $this->json(['error' => 'Image not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($sousService);
        $this->entityManager->flush();

        return $this->json(['message' => 'Sous service supprimée avec succès'], Response::HTTP_OK);
    }
}