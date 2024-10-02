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
        if (!$entity) {
            $entity = new SousService();
        }

        $entity->setNomSousService($data['nomSousService'] ?? $entity->getNomSousService());
        $entity->setDescription($data['description'] ?? $entity->getDescription());
        $entity->setTypeSousService($data['typeSousService'] ?? $entity->getTypeSousService());
            
        if (isset($data['idService']) && !empty($data['idService'])) {
            $service = $this->entityManager->getRepository(Services::class)->find($data['idService']);
            if (!$service) {
                throw new \InvalidArgumentException('Service non trouvé pour l\'ID donné.');
            }
            $entity->setService($service);
        } else {
            throw new \InvalidArgumentException('L\'ID du service est requis pour associer le sous-service.');
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

            return $entity;
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
}
