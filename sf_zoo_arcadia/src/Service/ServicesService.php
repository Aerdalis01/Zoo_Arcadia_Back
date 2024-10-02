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
            
            if (!$entity) {
                $entity = new Services();
            }
            
            $entity->setNomService($data['nomService'] ?? $entity->getNomService());
            $entity->setTitreService($data['titreService'] ?? $entity->getTitreService());
            $entity->setDescription($data['description'] ?? $entity->getDescription());
            $entity->setTypeService($data['typeService'] ?? $entity->getTypeService());
            

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
    
}
