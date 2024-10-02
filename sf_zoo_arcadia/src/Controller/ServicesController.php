<?php

namespace App\Controller;


use App\Entity\Services;
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
            

            if (!$nom || !$type) {
                return new JsonResponse(['status' => 'error', 'message' => 'Paramètres nom ou type manquants.'], 400);
            }
            if ($file !== null){
            $image = $imageManagerService->createImage($imageName, $imageSubDirectory, $file);
            }
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
        try {
            $nom = $request->request->get('nomService'); 
            $description = $request->request->get('description');
            $type = $request->request->get('typeService');
            $titre = $request->request->get('titreService');
                
            // Vérification des paramètres
            if ($nom !== null) {
                $service->setNomService($nom);
            }
            if ($type !== null) {
                $service->setTypeService($type);
            }

            // Suppression du titre si non fourni
            if ($request->request->get('titreService') === null) {
                $service->setTitreService(null); // Supprimer le titre existant
            }
            if ($request->request->get('description') === null) {
                $service->setDescription(null); // Supprimer le titre existant
            }
            
            // Mise à jour du service
            $service->setNomService($nom);
            $service->setDescription($description);
            $service->setTitreService($titre);
            $service->setTypeService($type);
            
    
            // Suppression des sous-services associés
            $sousServices = $service->getSousServices(); 
            if($sousServices) {
            foreach ($sousServices as $sousService) {
                $this->entityManager->remove($sousService);
            }}

            $removeImage = $request->request->get('removeImage'); // On récupère l'indicateur de suppression
            if ($removeImage === 'true') {
                foreach ($service->getImages() as $image) {
                $service->removeImage($image);
                $this->entityManager->remove($image);
                }
            }
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