<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\Column]
    private ?bool $valide = false;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?ZooArcadia $ZooArcadia = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?Employe $employe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function isValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(bool $valide): static
    {
        $this->valide = $valide;

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
