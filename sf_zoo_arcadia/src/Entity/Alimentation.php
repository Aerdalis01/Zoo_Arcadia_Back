<?php

namespace App\Entity;

use App\Repository\AlimentationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlimentationRepository::class)]
class Alimentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'alimentations')]
    private ?veterinaire $vétérinaire = null;

    #[ORM\ManyToOne(inversedBy: 'alimentations')]
    private ?compteRenduVet $compteRenduVet = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $time = null;

    #[ORM\Column(length: 255)]
    private ?string $nourriture = null;

    #[ORM\Column]
    private ?float $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'alimentations')]
    private ?employe $employe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVeterinaire(): ?veterinaire
    {
        return $this->vétérinaire;
    }

    public function setVeterinaire(?veterinaire $vétérinaire): static
    {
        $this->vétérinaire = $vétérinaire;

        return $this;
    }

    public function getCompteRenduVet(): ?compteRenduVet
    {
        return $this->compteRenduVet;
    }

    public function setCompteRenduVet(?compteRenduVet $compteRenduVet): static
    {
        $this->compteRenduVet = $compteRenduVet;

        return $this;
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

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): static
    {
        $this->time = $time;

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

    public function getEmploye(): ?employe
    {
        return $this->employe;
    }

    public function setEmploye(?employe $employe): static
    {
        $this->employe = $employe;

        return $this;
    }
}
