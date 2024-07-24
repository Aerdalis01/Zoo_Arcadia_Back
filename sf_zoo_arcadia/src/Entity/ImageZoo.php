<?php

namespace App\Entity;

use App\Repository\ImageZooRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageZooRepository::class)]
class ImageZoo
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
    private ?string $imagesubDirectory = null;


    #[ORM\OneToOne(inversedBy: 'habitats', orphanRemoval: true)]
    private ?Habitats $habitats = null;
    


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
        return $this->imagesubDirectory;
    }

    public function setImageSubDirectory(string $imagesubDirectory): static
    {
        $this->imagesubDirectory = $imagesubDirectory;

        return $this;
    }

    public function getHabitats(): ?Habitats
    {
        return $this->habitats;
    }

    public function setHabitats(?Habitats $habitats): static
    {
        $this->habitats = $habitats;

        return $this;
    }
}
