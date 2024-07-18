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
    private ?string $titre = null;

    #[ORM\Column]
    private array $image = [];

    #[ORM\ManyToOne(inversedBy: 'imageZoos')]
    private ?ZooArcadia $ZooArcadia = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getImage(): array
    {
        return $this->image;
    }

    public function setImage(array $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getZooArcadia(): ?ZooArcadia
    {
        return $this->ZooArcadia;
    }

    public function setZooArcadia(?ZooArcadia $ZooArcadia): static
    {
        $this->ZooArcadia = $ZooArcadia;

        return $this;
    }
}
