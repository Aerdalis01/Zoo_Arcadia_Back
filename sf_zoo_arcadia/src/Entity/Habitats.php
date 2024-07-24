<?php

namespace App\Entity;

use App\Repository\HabitatsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: HabitatsRepository::class)]
class Habitats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private array $image = [];

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(inversedBy: 'habitats', cascade: ['persist', 'remove'])]
    private ?ImageZoo $imageZoo = null;

    #[ORM\ManyToOne(targetEntity: ZooArcadia::class, inversedBy: 'habitats', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?ZooArcadia $zooArcadia = null;

    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'habitats', orphanRemoval: true)]
    private Collection $animals;

    #[ORM\ManyToOne(inversedBy: 'habitats', cascade: ['persist', 'remove'])]
    private ?Admin $admin = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

    

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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
    
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    public function getZooArcadia(): ?ZooArcadia
    {
        return $this->zooArcadia;
    }

    public function setZooArcadia(?ZooArcadia $zooArcadia): self
    {
        $this->zooArcadia = $zooArcadia;
        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setHabitats($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getHabitats() === $this) {
                $animal->setHabitats(null);
            }
        }

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): static
    {
        $this->admin = $admin;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    
    public function getImageZoo(): ?ImageZoo
    {
        return $this->imageZoo;
    }

    public function setImageZoo(?ImageZoo $imageZoo): static
    {
        $this->imageZoo = $imageZoo;

        return $this;
    }
}