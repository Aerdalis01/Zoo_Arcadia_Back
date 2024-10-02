<?php

namespace App\Controller;

use App\Entity\InfoService;
use App\Entity\PetitTrain;
use App\Entity\Restauration;
use App\Entity\Services;
use App\Entity\VisiteGuidee;
use App\Repository\ServicesRepository;
use App\Service\ImageManagerService;
use App\Service\ServicesService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/services', name: 'app_api_services_')]
class ServicesController extends AbstractController
{
    public function __construct(private ServicesService $servicesService, private EntityManagerInterface $entityManager, private LoggerInterface $logger, private ImageManagerService $imageManagerService)
    {}

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
        $service = $entityManager->getRepository(Services::class)->find($id);
        if (!$service) {
            return new JsonResponse(['error' => 'Service not found'], 404);
        }
        
        $data = $serializer->serialize($service, 'json', ['groups' => 'services_basic']);

        
        return new JsonResponse(json_decode($data), JsonResponse::HTTP_OK);
    }

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function createService(Request $request, ImageManagerService $imageManagerService):JsonResponse
    {
        try {
            $nom = $request->request->get('nomService'); 
            $description = $request->request->get('description');
            $type = $request->request->get('typeService');
            $titre = $request->request->get('titreService');

            $file = $request->files->get('file');
            $imageSubDirectory = $request->request->get('image_sub_directory');
            $imageName = $request->request->get('nom');
            

            if (!$nom || !$description || !$type || !$titre) {
                return new JsonResponse(['status' => 'error', 'message' => 'Paramètres manquants.'], 400);
            }
    
            if (!$file) {
                return new JsonResponse(['status' => 'error', 'message' => 'Fichier image manquant.'], 400);
            }
    
            $image = $imageManagerService->createImage($imageName, $imageSubDirectory, $file);

            // Créer ou mettre à jour le -service avec le service ServiceService
            $Service = $this->servicesService->createOrUpdateService(null, [
                'nomService' => $nom,
                'description' => $description,
                'typeService' => $type,
                'titreService' => $titre
            ], $image);

            return new JsonResponse(['status' => 'success', 'id' => $Service->getId()], 201);

        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
        }
    }
    #[Route('/{id}', name: 'update', methods: ['POST'])]
    public function updateService(int $id, Request $request): JsonResponse
    {
        $service = $this->entityManager->getRepository(Services::class)->find($id);

            if (!$service) {
                return new JsonResponse(['status' => 'error', 'message' => 'Service ou Service non trouvé'], 404);
            }
            if (!($service instanceof Services)) {
                return new JsonResponse(['status' => 'error', 'message' => 'L\'entité récupérée n\'est pas du type attendu.'], 400);
            }
        try {
            $nom = $request->request->get('nomService'); 
            $description = $request->request->get('description');
            $type = $request->request->get('typeService');
            $titre = $request->request->get('titreService');
            
            if (!$nom || !$description || !$type || !$titre) {
            return new JsonResponse(['status' => 'error', 'message' => 'Paramètres manquants.'], 400);
            }

            //Comparer le type actuel de l'entité au type reçu dans le formulaire
            $currentType = (new \ReflectionClass($service))->getShortName();
            // Appel de la function convertServiceType pour modifier le type de service
            if ($type !== $currentType) {
                $service = $this->servicesService->convertServiceType($service, $type);
                if (!$service) {
                    return new JsonResponse(['status' => 'error', 'message' => 'Impossible de changer le type du service'], 400);
                }
            }
            // Mise à jour du service
            $service->setNomService($nom);
            $service->setDescription($description);
            $service->setTitreService($titre);
            
    
            // Suppression des sous-services associés
            $sousServices = $service->getSousServices(); 
            if($sousServices) {
            foreach ($sousServices as $sousService) {
                $this->entityManager->remove($sousService);
            }}
            //Suppression de l'image associés
            foreach($service->getImages() as $image){
                $service->removeImage($image);
                $this->entityManager->remove($image);
            } 
            
            
            // Gestion du fichier (image) si présent
            $file = $request->files->get('file');
            if ($file) {
                $imageName = $request->request->get('nom');
                $imageSubDirectory = $request->request->get('image_sub_directory');
                
                if (!is_string($imageName) || empty($imageName) || !is_string($imageSubDirectory) || empty($imageSubDirectory)) {
                    return new JsonResponse(['status' => 'error', 'message' => 'Informations sur l\'image invalides.'], 400);
                }
            
                // Création d'une nouvelle instance de l'entité `Images`
                $image = $this->imageManagerService->createImage($imageName, $imageSubDirectory, $file);
            
                // Ajout de l'image au service via la méthode addImage
                $service->addImage($image);
            }
            // Sauvegarde du service
            $this->entityManager->persist($service);
            $this->entityManager->flush();
    
            return new JsonResponse(['status' => 'success', 'id' => $service->getId()], 200);
    
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