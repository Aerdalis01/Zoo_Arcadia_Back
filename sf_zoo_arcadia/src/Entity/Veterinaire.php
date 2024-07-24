<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Veterinaire extends User
{
    #[ORM\OneToMany(targetEntity: CompteRenduVet::class, mappedBy: 'veterinaire')]
    private Collection $compteRenduVets;

    #[ORM\OneToMany(targetEntity: Alimentation::class, mappedBy: 'veterinaire')]
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
            $compteRenduVet->setVeterinaire($this);
        }

        return $this;
    }

    public function removeCompteRenduVet(CompteRenduVet $compteRenduVet): static
    {
        if ($this->compteRenduVets->removeElement($compteRenduVet)) {
            // set the owning side to null (unless already changed)
            if ($compteRenduVet->getVeterinaire() === $this) {
                $compteRenduVet->setVeterinaire(null);
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
            $alimentation->setVeterinaire($this);
        }

        return $this;
    }

    public function removeAlimentation(Alimentation $alimentation): static
    {
        if ($this->alimentations->removeElement($alimentation)) {
            // set the owning side to null (unless already changed)
            if ($alimentation->getveterinaire() === $this) {
                $alimentation->setVeterinaire(null);
            }
        }

        return $this;
    }
}