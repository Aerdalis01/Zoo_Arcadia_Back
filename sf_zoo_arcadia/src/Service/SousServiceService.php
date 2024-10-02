<?php

namespace App\Service;

use App\Entity\Services;
use App\Entity\SousService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SousServiceService
{
    private EntityManagerInterface $entityManager;
    private ImageManagerService $imageManager;


    public function __construct(EntityManagerInterface $entityManager, ImageManagerService $imageManager)
    {
        $this->entityManager = $entityManager;
        $this->imageManager = $imageManager;

    }

    public function createOrUpdateSousService(?SousService $entity, array $data, $image): SousService
    {
        
        if ($entity === null && isset($data['typeSousService'])) {
            $entity = $this->instantiateSousService($data['typeSousService']);

            if (!$entity) {
                throw new \InvalidArgumentException('Type de sous service non valide');
            }
        }

        if ($entity instanceof SousService) {
            $entity->setNomSousService($data['nomSousService'] ?? $entity->getNomSousService());
            $entity->setDescription($data['description'] ?? $entity->getDescription());
            
            if (isset($data['nomService']) && !empty($data['nomService'])) {
                $service = $this->entityManager->getRepository(Services::class)->find(['id' => $data['nomService']]);
                if (!$service) {
                    throw new \InvalidArgumentException('Service non trouvé pour le nom donné.');
                }
                $entity->setService($service);
            } else {
                throw new \InvalidArgumentException('Le nom du service est requis pour associer le sous-service.');
            }
    
            if (!$entity->getCreatedAt()) {
                $entity->setCreatedAt(new \DateTimeImmutable());
            }
            $entity->setUpdatedAt(new \DateTimeImmutable());
    
            // Initialisation des images si nécessaire
            $images = $entity->getImages();
            if ($images instanceof PersistentCollection && !$images->isInitialized()) {
                $this->entityManager->initializeObject($images);
            }
            
                    if ($image) {
                        $entity->addImage($image);
                    }
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        }
        return $entity;
        throw new \RuntimeException('Échec de la création ou de la mise à jour du sous-service.');
    }
    
    private function instantiateSousService(?string $type): ?SousService
    {
        switch ($type) {
            case 'restaurant':
                return new \App\Entity\Restaurant();
            case 'snack':
                return new \App\Entity\Snack();
            case 'camion_glace':
                return new \App\Entity\CamionGlace();
            default:
            return null;
        }
    }

    public function deleteSousService(object $entity): void
    {
        // Suppression des images associées
        foreach ($entity->getImages() as $image) {
            $this->imageManager->deleteImage($image->getImagePath());
            $this->entityManager->remove($image);
        }

        // Si c'est un Service, supprimer ses SousServices
        if ($entity instanceof Services) {
            foreach ($entity->getSousServices() as $sousService) {
                $this->deleteSousService($sousService);
            }
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function convertSousServiceType(SousService $oldSousService, string $newType): ?SousService
    {
        // Vérifier si le nouveau type est valide 
        $validTypes = ['restaurant', 'snack', 'camion_glace'];
        if (!in_array($newType, $validTypes)) {
            return null;
        }

        // Création d'une nouvelle instance de l'entité cible
        $newService = null;
        switch ($newType) {
            case 'restaurant':
                return new \App\Entity\Restaurant();
            case 'snack':
                return new \App\Entity\Snack();
            case 'camion_glace':
                return new \App\Entity\CamionGlace();
            default:
            return null;
        }

        // Copier les propriétés communes de l'ancien service vers le nouveau
        $newSousService->setNomService($oldSousService->getNomService());
        $newSousService->setDescription($oldSousService->getDescription());
        $newSousService->setTitreService($oldSousService->getTitreService());

        // Copier les relations si nécessaire
        foreach ($oldSousService->getImages() as $image) {
            $newService->addImage($image);
        }

        // Supprimer l'ancien service
        $this->entityManager->remove($oldSousService);

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
        
        $newSousService = $this->convertSousServiceType($service, $newType);

        if (!$newSousService) {
            return new JsonResponse(['status' => 'error', 'message' => 'Impossible de changer le type du service'], 400);
        }

        // Sauvegarder la nouvelle entité
        $this->entityManager->persist($newSousService);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'success', 'id' => $newSousService->getId()], 200);
    }
}
