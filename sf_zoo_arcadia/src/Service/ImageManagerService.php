<?php

namespace App\Service;

use App\Entity\Images;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\Image;

class ImageManagerService
{
    
    private $imageDirectory;
    private $entityManager;

    public function __construct(string $imageDirectory, EntityManagerInterface $entityManager, private SluggerInterface $sluggerInterface, private ParameterBagInterface $parameterBag, private LoggerInterface $loggerInterface )
    {
        $this->imageDirectory = $imageDirectory;
        $this->entityManager = $entityManager;
    }

    public function createImage(?string $nom, ?string $imageSubDirectory, $file): Images
    {

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->sluggerInterface->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        // Créer le chemin complet avec images_directory et image_sub_directory
        $uploadDirectory = $this->parameterBag->get('images_directory') . '/' . $imageSubDirectory;

        // Créez le sous-dossier s'il n'existe pas
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        try {
            // Déplacer le fichier vers le bon répertoire
            $file->move($uploadDirectory, $newFilename);
        } catch (FileException $e) {
            $this->loggerInterface->error($e->getMessage());
        }

        // Stocker le chemin du fichier dans l'entité Image
        $image = new Images();
        $image->setNom($nom);
        $image->setImagePath($newFilename);
        $image->setImageSubDirectory($imageSubDirectory);

        $this->entityManager->persist($image);
        $this->entityManager->flush();


        return $image;
    }

    

    public function deleteImage(string $imagePath): void
    {
        $filePath = $this->imageDirectory.'/'.$imagePath;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
