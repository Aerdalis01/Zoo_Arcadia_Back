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

class ServicesService
{
    private EntityManagerInterface $entityManager;
    private ImageManager $imageManager;
    private LoggerInterface $logger;

    public function __construct(EntityManagerInterface $entityManager, ImageManager $imageManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->imageManager = $imageManager;
        $this->logger = $logger;
    }

    
    public function createOrUpdateService(object $entity, array $data): object
    {
        if ($entity === null && isset($data['type'])) {
            $entity = $this->instantiateService($data['type']);
        
            if (!$entity) {
                throw new \InvalidArgumentException('Type de service non valide');
            }
        }
        
        if ($entity instanceof Services) {
            $this->logger->info('Modification du service avec ID : ' . $entity->getId());

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
            // Gestion des images du service
            if (isset($data['images']) && is_array($data['images'])) {
                foreach ($data['images'] as $imageData) {
                    $image = $this->imageManager->manageImage(
                        $entity,
                        $imageData['id'] ?? null,
                        $imageData['nom'] ?? null,
                        $imageData['imagePath'] ?? null,
                        $imageData['imageSubDirectory'] ?? null
                    );
                    if ($image) {
                        $entity->addImage($image);
                        $this->entityManager->persist($image); 
                    }
                }
            }
            $this->entityManager->persist($entity);
            $this->entityManager->flush(); 

        return $entity;
        }
    }
    public function createOrUpdateServiceByType(array $data): object
    {   
        // Instancier la bonne sous-classe de Services en fonction du type
        $service = $this->instantiateService($data['type']);
        if (!$service) {
            throw new \InvalidArgumentException('Type de service non valide');
        }

        // Appeler createOrUpdateService pour gérer les sous-services et les images
        return $this->createOrUpdateService($service, $data);
    }   
    // Instancier la sous-classe concrète de SousService
    
    private function instantiateService(string $type): ?object
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
}
