<?php

namespace App\Entity;

use App\Repository\ZooArcadiaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZooArcadiaRepository::class)]
class ZooArcadia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $nom = null;

    #[ORM\Column(length: 75)]
    private ?string $adresse = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: Habitats::class, mappedBy: 'zooArcadia', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $habitats;

    #[ORM\OneToMany(targetEntity: Services::class, mappedBy: 'zooArcadia', orphanRemoval: true)]
    private Collection $services;

    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'zooArcadia', orphanRemoval: true)]
    private Collection $avis;

    #[ORM\OneToMany(targetEntity: Horaire::class, mappedBy: 'zooArcadia', orphanRemoval: true)]
    private Collection $horaires;

    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'zooArcadia', orphanRemoval: true)]
    private Collection $animals;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Carousel $carousel = null;

    

    public function __construct()
    {
        $this->habitats = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->horaires = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

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

    /**
     * @return Collection<int, Habitats>
     */
    public function getHabitats(): Collection
    {
        return $this->habitats;
    }

    public function addHabitat(Habitats $habitat): self
    {
        if (!$this->habitats->contains($habitat)) {
            $this->habitats[] = $habitat;
            $habitat->setZooArcadia($this);
        }

        return $this;
    }

    public function removeHabitat(Habitats $habitat): self
    {
        if ($this->habitats->removeElement($habitat)) {
            if ($habitat->getZooArcadia() === $this) {
                $habitat->setZooArcadia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Services>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Services $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setZooArcadia($this);
        }

        return $this;
    }

    public function removeService(Services $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getZooArcadia() === $this) {
                $service->setZooArcadia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setZooArcadia($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getZooArcadia() === $this) {
                $avi->setZooArcadia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Horaire>
     */
    public function getHoraires(): Collection
    {
        return $this->horaires;
    }

    public function addHoraire(Horaire $horaire): static
    {
        if (!$this->horaires->contains($horaire)) {
            $this->horaires->add($horaire);
            $horaire->setZooArcadia($this);
        }

        return $this;
    }

    public function removeHoraire(Horaire $horaire): static
    {
        if ($this->horaires->removeElement($horaire)) {
            // set the owning side to null (unless already changed)
            if ($horaire->getZooArcadia() === $this) {
                $horaire->setZooArcadia(null);
            }
        }

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
            $animal->setZooArcadia($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getZooArcadia() === $this) {
                $animal->setZooArcadia(null);
            }
        }

        return $this;
    }

    public function getCarousel(): ?Carousel
    {
        return $this->carousel;
    }

    public function setCarousel(?Carousel $carousel): static
    {
        $this->carousel = $carousel;

        return $this;
    }


}
