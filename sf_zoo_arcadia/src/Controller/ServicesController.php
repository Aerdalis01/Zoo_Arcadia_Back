<?php

namespace App\Controller;


use App\Entity\Services;
use App\Repository\ServicesRepository;
use App\Service\ServicesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/services', name: 'app_api_services_')]
class ServicesController extends AbstractController
{
    private ServicesService $servicesService;
    private EntityManagerInterface $entityManager;

    public function __construct(ServicesService $servicesService, EntityManagerInterface $entityManager)
    {
        $this->servicesService = $servicesService;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $services = $entityManager->getRepository(Services::class)->findAll();
        $data = $serializer->serialize($services, 'json', ['groups' => 'services_basic']);
        return new JsonResponse(json_decode($data), JsonResponse::HTTP_OK);
    }
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $services = $entityManager->getRepository(Services::class)->find($id);
        $data = $serializer->serialize($services, 'json', ['groups' => 'services_basic']);
        return new JsonResponse(json_decode($data), JsonResponse::HTTP_OK);
    }

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function createServiceWithSubServices(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Vérification si le type est fourni dans les données
        if (!isset($data['type'])) {
            return new JsonResponse(['status' => 'error', 'message' => 'Type de service manquant'], 400);
        }

        try {
            // Appeler le service pour créer ou mettre à jour un service avec les sous-services et images
            $service = $this->servicesService->createOrUpdateServiceByType($data);

            return new JsonResponse(['status' => 'success', 'id' => $service->getId()], 201);

        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
        }
    }
    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function updateService(int $id,Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $Service = $this->entityManager->getRepository(Services::class)->find($id);

        if (!$Service) {
            $service = $this->entityManager->getRepository(Services::class)->find($id);
            if (!$service) {
                return new JsonResponse(['status' => 'error', 'message' => 'Service ou SousService non trouvé'], 404);
            }
        }
        try {
            if ($Service) {
                
                $this->servicesService->createOrUpdateService($Service, $data);
                return new JsonResponse(['status' => 'success', 'id' => $Service->getId()], 200);
            } 

        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
        }
    }
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, ServicesRepository $ServicesRepository): Response
    {
        $Service = $ServicesRepository->find($id);
        
        if (!$Service) {
            return $this->json(['error' => 'Image not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($Service);
        $this->entityManager->flush();

        return $this->json(['message' => 'Service supprimée avec succès'], Response::HTTP_OK);
    }

}