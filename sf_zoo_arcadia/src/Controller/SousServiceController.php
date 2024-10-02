<?php

namespace App\Controller;



use App\Entity\SousService;
use App\Repository\SousServiceRepository;
use App\Service\ImageManagerService;
use App\Service\SousServiceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/sousService', name: 'app_api_sous_service_')]
class SousServiceController extends AbstractController
{
    public function __construct(
        private SousServiceService $sousServiceService,
        private EntityManagerInterface $entityManager, 
        private ImageManagerService $imageManagerService
    ){}

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
    public function createSousService(Request $request, ImageManagerService $imageManagerService):JsonResponse
    {
        try {
            $nom = $request->request->get('nomSousService'); 
            $description = $request->request->get('description');
            $type = $request->request->get('typeSousService');
            $idService = $request->request->get('idService');

            $file = $request->files->get('file');
            $imageSubDirectory = $request->request->get('image_sub_directory');
            $imageName = $request->request->get('nom');

            if (!$nom || !$description || !$type || !$idService) {
                return new JsonResponse(['status' => 'error', 'message' => 'Paramètres manquants.'], 400);
            }
    
            if (!$file) {
                return new JsonResponse(['status' => 'error', 'message' => 'Fichier image manquant.'], 400);
            }
    
            $image = $imageManagerService->createImage($imageName, $imageSubDirectory, $file);

            // Créer ou mettre à jour le sous-service avec le service sousServiceService
            $sousService = $this->sousServiceService->createOrUpdateSousService(null, [
                'nomSousService' => $nom,
                'description' => $description,
                'typeSousService' => $type,
                'idService' => $idService
            ], $image);

            return new JsonResponse(['status' => 'success', 'id' => $sousService->getId()], 201);

        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
        }
    }

    // #[Route('/{id}', name: 'update', methods: ['PUT'])]
    // public function updateService(int $id,Request $request): JsonResponse
    // {
    //     $data = json_decode($request->getContent(), true);

    //     $sousService = $this->entityManager->getRepository(SousService::class)->find($id);

    //     if (!$sousService) {
    //         $service = $this->entityManager->getRepository(Services::class)->find($id);
    //         if (!$service) {
    //             return new JsonResponse(['status' => 'error', 'message' => 'Service ou SousService non trouvé'], 404);
    //         }
    //     }
    //     try {
    //         if ($sousService) {
                
    //             $this->sousServiceService->createOrUpdateSousService($sousService, $data, $image);
    //             return new JsonResponse(['status' => 'success', 'id' => $sousService->getId()], 200);
    //         } else {
                
    //             $this->sousServiceService->createOrUpdateSousService($service, $data, $image);
    //             return new JsonResponse(['status' => 'success', 'id' => $service->getId()], 200);
    //         }

    //     } catch (\Exception $e) {
    //         return new JsonResponse(['status' => 'error', 'message' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
    //     }
    // }

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