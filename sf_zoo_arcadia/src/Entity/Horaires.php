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

    #[ORM\Column(type: Types::JSON)]
    private array $heureOuverture = [];

    #[ORM\Column(type: Types::JSON)]
    private array $heureFermeture = [];


    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'horaires')]
    private ?InfoService $infoService = null;

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

    public function getHeureOuverture(): array
    {
        return $this->heureOuverture;
    }

    public function setHeureOuverture(array $heureOuverture): static
    {
        $this->heureOuverture = $heureOuverture;

        return $this;
    }

    public function getHeureFermeture(): array
    {
        return $this->heureFermeture;
    }

    public function setHeureFermeture(array $heureFermeture): static
    {
        $this->heureFermeture = $heureFermeture;

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

    public function getInfoService(): ?InfoService
    {
        return $this->infoService;
    }

    public function setInfoService(?InfoService $infoService): static
    {
        $this->infoService = $infoService;

        return $this;
    }
}
