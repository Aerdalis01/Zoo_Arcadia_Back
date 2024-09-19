<?php

namespace App\Entity;

use App\Repository\AnimauxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnimauxRepository::class)]
class Animaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('animaux_basic')]
    private ?int $id = null;
    #[Groups('animaux_basic')]
    #[ORM\Column(length: 25)]
    private ?string $prenom = null;



    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: RapportAlimentation::class, mappedBy: 'animal')]
    private Collection $rapportAlimentations;

    #[ORM\OneToMany(targetEntity: Consultation::class, mappedBy: 'animal')]
    private Collection $consultations;

    #[ORM\ManyToOne(inversedBy: 'animaux')]
    private ?Habitats $habitats = null;

    #[ORM\ManyToOne(inversedBy: 'animaux')]
    private ?Races $race = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Images $image = null;

    #[ORM\OneToMany(targetEntity: CompteRenduVet::class, mappedBy: 'animaux')]
    private Collection $compteRenduVet;

    public function __construct()
    {
        $this->rapportAlimentations = new ArrayCollection();
        $this->consultations = new ArrayCollection();
        $this->compteRenduVet = new ArrayCollection();
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
            $consultation->setAnimal($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): static
    {
        if ($this->consultations->removeElement($consultation)) {
            if ($consultation->getAnimal() === $this) {
                $consultation->setAnimal(null);
            }
        }

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

    public function getRace(): ?Races
    {
        return $this->race;
    }

    public function setRace(?Races $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getImage(): ?Images
    {
        return $this->image;
    }

    public function setImage(?Images $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, CompteRenduVet>
     */
    public function getCompteRenduVet(): Collection
    {
        return $this->compteRenduVet;
    }

    public function addCompteRenduVet(CompteRenduVet $compteRenduVet): static
    {
        if (!$this->compteRenduVet->contains($compteRenduVet)) {
            $this->compteRenduVet->add($compteRenduVet);
            $compteRenduVet->setAnimaux($this);
        }

        return $this;
    }

    public function removeCompteRenduVet(CompteRenduVet $compteRenduVet): static
    {
        if ($this->compteRenduVet->removeElement($compteRenduVet)) {
            if ($compteRenduVet->getAnimaux() === $this) {
                $compteRenduVet->setAnimaux(null);
            }
        }

        return $this;
    }


}
