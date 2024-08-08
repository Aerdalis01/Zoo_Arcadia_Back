<?php

namespace App\Entity;

use App\Repository\HorairesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HorairesRepository::class)]
class Horaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $jour = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $heureOuvertureZoo = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $heureFermetureZoo = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private array $horairesServices = [];

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'horaires')]
    private ?InfoService $infoService = null;

    #[ORM\ManyToOne(inversedBy: 'horaires')]
    private ?Admin $admin = null;

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

    public function getInfoService(): ?InfoService
    {
        return $this->infoService;
    }

    public function setInfoService(?InfoService $infoService): static
    {
        $this->infoService = $infoService;

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
}
