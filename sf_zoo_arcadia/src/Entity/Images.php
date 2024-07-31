<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?string $imagePath = null;

    #[ORM\Column]
    private ?string $imageSubDirectory = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Services $services = null;

    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagepath): static
    {
        $this->imagePath = $imagepath;

        return $this;
    }


    public function getImageSubDirectory(): string
    {
        return $this->imageSubDirectory;
    }

    public function setImageSubDirectory(string $imageSubDirectory): static
    {
        $this->imageSubDirectory = $imageSubDirectory;

        return $this;
    }

    public function getServices(): ?Services
    {
        return $this->services;
    }

    public function setServices(?Services $services): static
    {
        $this->services = $services;

        return $this;
    }

}
