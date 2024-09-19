<?php

namespace App\Entity;

use App\Repository\HabitatsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: HabitatsRepository::class)]
class Habitats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(targetEntity: Animaux::class, mappedBy: 'habitats')]
    private Collection $animaux;

    #[ORM\OneToOne(targetEntity: Images::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Images $image = null;

    #[ORM\OneToMany(targetEntity: CommentairesHabitat::class, mappedBy: 'habitat')]
    private Collection $commentairesHabitats;

    public function __construct()
    {
        $this->animaux = new ArrayCollection();
        $this->commentairesHabitats = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        error_log('Habitats::setNom - nom: ' . $nom);
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Animaux>
     */
    public function getAnimaux(): Collection
    {
        return $this->animaux;
    }

    public function addAnimaux(Animaux $animaux): static
    {
        if (!$this->animaux->contains($animaux)) {
            $this->animaux->add($animaux);
            $animaux->setHabitats($this);
        }

        return $this;
    }

    public function removeAnimaux(Animaux $animaux): static
    {
        if ($this->animaux->removeElement($animaux)) {
            if ($animaux->getHabitats() === $this) {
                $animaux->setHabitats(null);
            }
        }

        return $this;
    }
    public function getImage(): ?Images
    {
        return $this->image;
    }

    public function setImage(?Images $image): self
    {
        $this->image = $image;
        return $this;
    }


    /**
     * @return Collection<int, CommentairesHabitat>
     */
    public function getCommentairesHabitats(): Collection
    {
        return $this->commentairesHabitats;
    }

    public function addCommentairesHabitat(CommentairesHabitat $commentairesHabitat): static
    {
        if (!$this->commentairesHabitats->contains($commentairesHabitat)) {
            $this->commentairesHabitats->add($commentairesHabitat);
            $commentairesHabitat->setHabitat($this);
        }

        return $this;
    }

    public function removeCommentairesHabitat(CommentairesHabitat $commentairesHabitat): static
    {
        if ($this->commentairesHabitats->removeElement($commentairesHabitat)) {
            if ($commentairesHabitat->getHabitat() === $this) {
                $commentairesHabitat->setHabitat(null);
            }
        }

        return $this;
    }

}