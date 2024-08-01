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

    #[ORM\ManyToOne(targetEntity: ZooArcadia::class, inversedBy: 'habitats', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?ZooArcadia $zooArcadia = null;


    #[ORM\ManyToOne(inversedBy: 'habitats', cascade: ['persist', 'remove'])]
    private ?Admin $admin = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\OneToMany(targetEntity: Animaux::class, mappedBy: 'habitats')]
    private Collection $animaux;

    #[ORM\OneToMany(targetEntity: Images::class, mappedBy: 'habitats')]
    private Collection $images;

    #[ORM\OneToMany(targetEntity: CommentairesHabitat::class, mappedBy: 'habitat')]
    private Collection $commentairesHabitats;

    public function __construct()
    {
        $this->animaux = new ArrayCollection();
        $this->images = new ArrayCollection();
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


    public function getZooArcadia(): ?ZooArcadia
    {
        return $this->zooArcadia;
    }

    public function setZooArcadia(?ZooArcadia $zooArcadia): self
    {
        $this->zooArcadia = $zooArcadia;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

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
            // set the owning side to null (unless already changed)
            if ($animaux->getHabitats() === $this) {
                $animaux->setHabitats(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setHabitats($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getHabitats() === $this) {
                $image->setHabitats(null);
            }
        }

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
            // set the owning side to null (unless already changed)
            if ($commentairesHabitat->getHabitat() === $this) {
                $commentairesHabitat->setHabitat(null);
            }
        }

        return $this;
    }

}