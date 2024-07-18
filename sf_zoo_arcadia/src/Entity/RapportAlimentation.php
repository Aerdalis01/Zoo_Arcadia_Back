<?php

namespace App\Entity;

use App\Repository\RapportAlimentationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportAlimentationRepository::class)]
class RapportAlimentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure = null;

    #[ORM\Column(length: 255)]
    private ?string $nourriture = null;

    #[ORM\Column]
    private ?float $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'rapportAlimentations')]
    private ?Animal $Animal = null;

    #[ORM\ManyToOne(inversedBy: 'rapportAlimentations')]
    private ?Employe $Employe = null;

    #[ORM\ManyToOne(inversedBy: 'Alimentation')]
    private ?CompteRenduVet $compteRenduVet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): static
    {
        $this->heure = $heure;

        return $this;
    }

    public function getNourriture(): ?string
    {
        return $this->nourriture;
    }

    public function setNourriture(string $nourriture): static
    {
        $this->nourriture = $nourriture;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->Animal;
    }

    public function setAnimal(?Animal $Animal): static
    {
        $this->Animal = $Animal;

        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->Employe;
    }

    public function setEmploye(?Employe $Employe): static
    {
        $this->Employe = $Employe;

        return $this;
    }

    public function getCompteRenduVet(): ?CompteRenduVet
    {
        return $this->compteRenduVet;
    }

    public function setCompteRenduVet(?CompteRenduVet $compteRenduVet): static
    {
        $this->compteRenduVet = $compteRenduVet;

        return $this;
    }
}