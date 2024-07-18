<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Veterinaire extends User
{
    #[ORM\OneToMany(targetEntity: CompteRenduVet::class, mappedBy: 'Vétérinaire')]
    private Collection $compteRenduVets;

    #[ORM\OneToMany(targetEntity: Alimentation::class, mappedBy: 'vétérinaire')]
    private Collection $alimentations;

    public function __construct()
    {
        $this->compteRenduVets = new ArrayCollection();
        $this->alimentations = new ArrayCollection();
    }

    /**
     * @return Collection<int, CompteRenduVet>
     */
    public function getCompteRenduVets(): Collection
    {
        return $this->compteRenduVets;
    }

    public function addCompteRenduVet(CompteRenduVet $compteRenduVet): static
    {
        if (!$this->compteRenduVets->contains($compteRenduVet)) {
            $this->compteRenduVets->add($compteRenduVet);
            $compteRenduVet->setVétérinaire($this);
        }

        return $this;
    }

    public function removeCompteRenduVet(CompteRenduVet $compteRenduVet): static
    {
        if ($this->compteRenduVets->removeElement($compteRenduVet)) {
            // set the owning side to null (unless already changed)
            if ($compteRenduVet->getVétérinaire() === $this) {
                $compteRenduVet->setVétérinaire(null);
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

    public function addAlimentation(Alimentation $alimentation): static
    {
        if (!$this->alimentations->contains($alimentation)) {
            $this->alimentations->add($alimentation);
            $alimentation->setVétérinaire($this);
        }

        return $this;
    }

    public function removeAlimentation(Alimentation $alimentation): static
    {
        if ($this->alimentations->removeElement($alimentation)) {
            // set the owning side to null (unless already changed)
            if ($alimentation->getVétérinaire() === $this) {
                $alimentation->setVétérinaire(null);
            }
        }

        return $this;
    }
}