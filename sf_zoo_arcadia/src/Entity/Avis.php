<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    #[Groups("avis_basic")]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    #[Groups("avis_basic")]
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups("avis_basic")]
    private ?string $commentaireAvis = null;

    #[ORM\Column]
    #[Groups("avis_basic")]
    private ?int $note = null;

    #[ORM\Column]
    #[Groups("avis_basic")]
    private ?bool $valide = false;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    #[Groups("avis_detail")]
    private ?Employe $employe = null;

    #[ORM\Column]
    #[Groups("avis_basic")]
    private ?\DateTimeImmutable $createdAt = null;

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

    public function getCommentaireAvis(): ?string
    {
        return $this->commentaireAvis;
    }

    public function setCommentaireAvis(string $commentaireAvis): static
    {
        $this->commentaireAvis = $commentaireAvis;

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


    public function getEmploye(): ?employe
    {
        return $this->employe;
    }

    public function setEmploye(?employe $employe): static
    {
        $this->employe = $employe;

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
}
