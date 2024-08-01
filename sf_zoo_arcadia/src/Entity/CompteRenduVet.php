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
}
