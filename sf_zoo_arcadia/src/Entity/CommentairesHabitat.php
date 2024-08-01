<?php

namespace App\Entity;

use App\Repository\CommentairesHabitatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentairesHabitatRepository::class)]
class CommentairesHabitat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaireHabitat = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'commentairesHabitats')]
    private ?Veterinaire $veterinaire = null;

    #[ORM\ManyToOne(inversedBy: 'commentairesHabitats')]
    private ?Habitats $habitat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaireHabitat(): ?string
    {
        return $this->commentaireHabitat;
    }

    public function setCommentaireHabitat(?string $commentaireHabitat): static
    {
        $this->commentaireHabitat = $commentaireHabitat;

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

    public function getVeterinaire(): ?Veterinaire
    {
        return $this->veterinaire;
    }

    public function setVeterinaire(?Veterinaire $veterinaire): static
    {
        $this->veterinaire = $veterinaire;

        return $this;
    }

    public function getHabitat(): ?Habitats
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitats $habitat): static
    {
        $this->habitat = $habitat;

        return $this;
    }
}
