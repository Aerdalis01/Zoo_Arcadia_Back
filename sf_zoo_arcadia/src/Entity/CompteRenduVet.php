<?php

namespace App\Entity;

use App\Repository\CompteRenduVetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompteRenduVetRepository::class)]
class CompteRenduVet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaireEtat = null;

    #[ORM\ManyToOne(inversedBy: 'compteRenduVets')]
    private ?Veterinaire $veterinaire= null;

    #[ORM\ManyToOne(inversedBy: 'compteRenduVet')]
    private ?Animaux $animaux = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaireEtat(): ?string
    {
        return $this->commentaireEtat;
    }

    public function setCommentaireEtat(?string $commentaireEtat): static
    {
        $this->commentaireEtat = $commentaireEtat;

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


    public function getAnimaux(): ?Animaux
    {
        return $this->animaux;
    }

    public function setAnimaux(?Animaux $animaux): static
    {
        $this->animaux = $animaux;

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
