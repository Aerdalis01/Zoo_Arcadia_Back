<?php

namespace App\Service;

use App\Entity\Services;
use App\Entity\SousService;
use App\Entity\InfoService;
use App\Entity\PetitTrain;
use App\Entity\Restauration;
use App\Entity\VisiteGuidee;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ServicesService
{
    private EntityManagerInterface $entityManager;
    private ImageManagerService $imageManager;
    private LoggerInterface $logger;

    public function __construct(EntityManagerInterface $entityManager, ImageManagerService $imageManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->imageManager = $imageManager;
        $this->logger = $logger;
    }

    
    public function createOrUpdateService(?Services $entity, array $data, $image): object
    {
        if ($entity === null && isset($data['typeService'])) {
            $entity = $this->instantiateService($data['typeService']);
        
            if (!$entity) {
                throw new \InvalidArgumentException('Type de service non valide');
            }
        }
        
        if ($entity instanceof Services) {
            $entity->setNomService($data['nomService'] ?? $entity->getNomService());
            $entity->setTitreService($data['titreService'] ?? $entity->getTitreService());
            $entity->setDescription($data['description'] ?? $entity->getDescription());
            

            if (!$entity->getCreatedAt()) {
                $entity->setCreatedAt(new \DateTimeImmutable());
            }
            $entity->setUpdatedAt(new \DateTimeImmutable()); 
            
            $images = $entity->getImages();
            if ($images instanceof PersistentCollection && !$images->isInitialized()) {
                $this->entityManager->initializeObject($images);
            }
            
                    if ($images) {
                        $entity->addImage($image);
                    }
            $this->entityManager->persist($entity);
            $this->entityManager->flush(); 

        return $entity;
        }
    }
    
    private function instantiateService(string $type): ?Services
    {
        switch ($type) {
            case 'restauration':
                return new Restauration();
            case 'visite_guidee':
                return new VisiteGuidee();
            case 'petit_train':
                return new PetitTrain();
            case 'info_service':
                return new InfoService();
            default:
                return null;
        }
    }



    public function deleteService(object $entity): void
    {
        // Suppression des images associées
        foreach ($entity->getImages() as $image) {
            $this->imageManager->deleteImage($image->getImagePath());
            $this->entityManager->remove($image);
        }

        // Si c'est un Service, supprimer ses SousServices
        if ($entity instanceof Services) {
            foreach ($entity->getSousServices() as $sousService) {
                $this->deleteService($sousService);
            }
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
    public function convertServiceType(Services $oldService, string $newType): ?Services
    {
        // Vérifier si le nouveau type est valide 
        $validTypes = ['restauration', 'visite_guidee', 'petit_train', 'info_service'];
        if (!in_array($newType, $validTypes)) {
            return null;
        }

        // Création d'une nouvelle instance de l'entité cible
        $newService = null;
        switch ($newType) {
            case 'restauration':
                $newService = new Restauration();
                break;
            case 'visite_guidee':
                $newService = new VisiteGuidee();
                break;
            case 'petit_train':
                return new PetitTrain();
            case 'info_service':
                return new InfoService();
            default:
                return null;
        }

        // Copier les propriétés communes de l'ancien service vers le nouveau
        $newService->setNomService($oldService->getNomService());
        $newService->setDescription($oldService->getDescription());
        $newService->setTitreService($oldService->getTitreService());

        // Copier les relations si nécessaire
        foreach ($oldService->getImages() as $image) {
            $newService->addImage($image);
        }

        foreach ($oldService->getSousServices() as $sousService) {
            $newService->addSousService($sousService);
        }

        // Supprimer l'ancien service
        $this->entityManager->remove($oldService);

        // Retourner la nouvelle instance
        return $newService;
    }
    public function changeServiceType(int $id, Request $request): JsonResponse
    {
        
        $service = $this->entityManager->getRepository(Services::class)->find($id);

        if (!$service) {
            return new JsonResponse(['status' => 'error', 'message' => 'Service non trouvé'], 404);
        }

        // Récupérer le nouveau type d'entité depuis la requête
        $newType = $request->request->get('newType'); 
        
        $newService = $this->convertServiceType($service, $newType);

        if (!$newService) {
            return new JsonResponse(['status' => 'error', 'message' => 'Impossible de changer le type du service'], 400);
        }

        // Sauvegarder la nouvelle entité
        $this->entityManager->persist($newService);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'success', 'id' => $newService->getId()], 200);
    }
}
