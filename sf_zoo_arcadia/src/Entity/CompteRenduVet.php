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
    private ?Veterinaire $Vétérinaire = null;

    #[ORM\OneToMany(targetEntity: RapportAlimentation::class, mappedBy: 'compteRenduVet')]
    private Collection $Alimentation;

    #[ORM\OneToMany(targetEntity: Alimentation::class, mappedBy: 'compteRenduVet')]
    private Collection $alimentations;

    #[ORM\ManyToOne(inversedBy: 'compteRenduVets')]
    private ?admin $admin = null;

    public function __construct()
    {
        $this->Alimentation = new ArrayCollection();
        $this->alimentations = new ArrayCollection();
    }

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

    public function getVétérinaire(): ?Veterinaire
    {
        return $this->Vétérinaire;
    }

    public function setVétérinaire(?Veterinaire $Vétérinaire): static
    {
        $this->Vétérinaire = $Vétérinaire;

        return $this;
    }

    /**
     * @return Collection<int, RapportAlimentation>
     */
    public function getAlimentation(): Collection
    {
        return $this->Alimentation;
    }

    public function addAlimentation(RapportAlimentation $alimentation): static
    {
        if (!$this->Alimentation->contains($alimentation)) {
            $this->Alimentation->add($alimentation);
            $alimentation->setCompteRenduVet($this);
        }

        return $this;
    }

    public function removeAlimentation(RapportAlimentation $alimentation): static
    {
        if ($this->Alimentation->removeElement($alimentation)) {
            // set the owning side to null (unless already changed)
            if ($alimentation->getCompteRenduVet() === $this) {
                $alimentation->setCompteRenduVet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Alimentation>
     */
    public function getAlimentations(): Collection
    {
        return $this->alimentations;
    }

    public function getAdmin(): ?admin
    {
        return $this->admin;
    }

    public function setAdmin(?admin $admin): static
    {
        $this->admin = $admin;

        return $this;
    }
}
