<?php

namespace App\Service;

use App\Entity\Images;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageManager
{
    private $entityManager;
    private $slugger;
    private $imageDirectory;

    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger, $imageDirectory)
    {
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
        $this->imageDirectory = $imageDirectory;
    }

    public function manageImage(object $entity, ?int $imageId, ?string $nom, ?string $imagePath, ?string $imageSubDirectory): ?Images
    {
      $images = $entity->getImages();


      $image = $images->filter(function (Images $img) use ($imageId) {
          return $img->getId() === $imageId;
      })->first();


      if ($image instanceof Images) {
          $image->setNom($nom);
          $image->setImagePath($imagePath);
          $image->setImageSubDirectory($imageSubDirectory);
      } else {

          if ($nom || $imagePath || $imageSubDirectory) {
              $image = new Images();
              $image->setNom($nom);
              $image->setImagePath($imagePath);
              $image->setImageSubDirectory($imageSubDirectory);
              $entity->addImage($image); 
          }
      }

      return $image ?? null;
  }

    public function deleteImage(string $imagePath): void
    {
        $filePath = $this->imageDirectory.'/'.$imagePath;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
