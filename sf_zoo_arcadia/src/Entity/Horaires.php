<?php

namespace App\Entity;

use App\Repository\HorairesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HorairesRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Horaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $jour = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $heureOuvertureZoo = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $heureFermetureZoo = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private array $horairesServices = [];

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true, type: 'datetime_immutable')]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'horaires')]
    private Services $infoService;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $titreHoraire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): static
    {
        $this->jour = $jour;

        return $this;
    }

    public function getHeureOuvertureZoo(): ?\DateTimeImmutable
    {
        return $this->heureOuvertureZoo;
    }

    public function setHeureOuvertureZoo(?\DateTimeImmutable $heureOuvertureZoo): static
    {
        $this->heureOuvertureZoo = $heureOuvertureZoo;

        return $this;
    }

    public function getHeureFermetureZoo(): ?\DateTimeImmutable
    {
        return $this->heureFermetureZoo;
    }

    public function setHeureFermetureZoo(?\DateTimeImmutable $heureFermetureZoo): static
    {
        $this->heureFermetureZoo = $heureFermetureZoo;

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

    public function getHorairesServices(): array
    {
        return $this->horairesServices;
    }

    public function setHorairesServices(array $horairesServices): static
    {
        $this->horairesServices = $horairesServices;

        return $this;
    }

    public function getInfoService(): ?Services
    {
        return $this->infoService;
    }

    public function setInfoService(?Services $infoService): static
    {
        $this->infoService = $infoService;

        return $this;
    }


    public function getTitreHoraire(): ?string
    {
        return $this->titreHoraire;
    }

    public function setTitreHoraire(?string $titreHoraire): static
    {
        $this->titreHoraire = $titreHoraire;

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
