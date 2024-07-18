<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $prenom = null;

    #[ORM\Column]
    private array $image = [];

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?ZooArcadia $ZooArcadia = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?Habitats $Habitats = null;

    #[ORM\ManyToOne(inversedBy: 'Animal')]
    private ?Race $race = null;

    #[ORM\OneToMany(targetEntity: RapportAlimentation::class, mappedBy: 'Animal')]
    private Collection $rapportAlimentations;

    #[ORM\ManyToMany(targetEntity: Consultation::class, mappedBy: 'animal')]
    private Collection $consultations;

    #[ORM\ManyToOne(inversedBy: 'animal')]
    private ?Admin $habitats = null;

    #[ORM\ManyToOne(inversedBy: 'animal')]
    private ?Admin $admin = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->rapportAlimentations = new ArrayCollection();
        $this->consultations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

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

    public function getHabitats(): ?Habitats
    {
        return $this->Habitats;
    }

    public function setHabitats(?Habitats $Habitats): static
    {
        $this->Habitats = $Habitats;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): static
    {
        $this->race = $race;

        return $this;
    }

    /**
     * @return Collection<int, RapportAlimentation>
     */
    public function getRapportAlimentations(): Collection
    {
        return $this->rapportAlimentations;
    }

    public function addRapportAlimentation(RapportAlimentation $rapportAlimentation): static
    {
        if (!$this->rapportAlimentations->contains($rapportAlimentation)) {
            $this->rapportAlimentations->add($rapportAlimentation);
            $rapportAlimentation->setAnimal($this);
        }

        return $this;
    }

    public function removeRapportAlimentation(RapportAlimentation $rapportAlimentation): static
    {
        if ($this->rapportAlimentations->removeElement($rapportAlimentation)) {
            // set the owning side to null (unless already changed)
            if ($rapportAlimentation->getAnimal() === $this) {
                $rapportAlimentation->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): static
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations->add($consultation);
            $consultation->addAnimal($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): static
    {
        if ($this->consultations->removeElement($consultation)) {
            $consultation->removeAnimal($this);
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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}