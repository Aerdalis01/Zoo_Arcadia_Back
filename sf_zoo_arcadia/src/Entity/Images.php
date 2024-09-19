<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    #[Groups("images_basic")]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    #[Groups("images_basic")]
    private ?string $nom = null;

    #[ORM\Column]
    #[Groups("images_basic")]
    private ?string $imagePath = null;

    #[ORM\Column]
    #[Groups("images_basic")]
    private ?string $imageSubDirectory = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[Ignore]
    private ?Services $services = null;

    #[ORM\ManyToOne(targetEntity: SousService::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    #[Ignore]
    private ?SousService $sousService = null;

    #[ORM\ManyToOne(targetEntity: Habitats::class ,inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: true)]
    #[Ignore]
    private ?Habitats $habitats = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Ignore]
    private ?Animaux $animal = null;


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

    public function getSousService(): ?SousService
    {
        return $this->sousService;
    }

    public function setSousService(?SousService $sousService): static
    {
        $this->sousService = $sousService;

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

    public function getAnimal(): ?Animaux
    {
        return $this->animal;
    }

    public function setAnimal(?Animaux $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

}
