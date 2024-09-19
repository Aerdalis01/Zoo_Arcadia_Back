<?php

namespace App\Service;

use App\Entity\Services;
use App\Entity\SousService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;


class SousServiceService
{
    private EntityManagerInterface $entityManager;
    private ImageManager $imageManager;


    public function __construct(EntityManagerInterface $entityManager, ImageManager $imageManager)
    {
        $this->entityManager = $entityManager;
        $this->imageManager = $imageManager;

    }

    public function createOrUpdateSousService(?SousService $entity, array $data): SousService
    {
        if ($entity === null && isset($data['type'])) {
            $entity = $this->instantiateSousService($data['type']);

            if (!$entity) {
                throw new \InvalidArgumentException('Type de sous service non valide');
            }
        }

        if ($entity instanceof SousService) {

            $entity->setNomSousService($data['nomSousService'] ?? $entity->getNomSousService());
            $entity->setDescription($data['description'] ?? $entity->getDescription());
            

            if (isset($data['nomService'])) {
                // Rechercher le service par son nom
                $service = $this->entityManager->getRepository(Services::class)->findOneBy(['nomService' => $data['nomService']]);
                if (!$service) {
                    throw new \InvalidArgumentException('Service non trouvé pour le nom donné.');
                }
    
                // Associer le service trouvé au sous-service
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
    
            // Gestion des images associées
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
    
            // Persistance de l'entité et des modifications
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        }
        return $entity;
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
}
