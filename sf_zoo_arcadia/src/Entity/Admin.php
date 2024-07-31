<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Admin extends User
{
    #[ORM\OneToMany(targetEntity: CompteRenduVet::class, mappedBy: 'admin')]
    private Collection $compteRenduVets;

    #[ORM\OneToMany(targetEntity: Consultation::class, mappedBy: 'admin')]
    private Collection $consultations;


    #[ORM\OneToMany(targetEntity: habitats::class, mappedBy: 'admin')]
    private Collection $habitats;


    public function __construct()
    {
        $this->compteRenduVets = new ArrayCollection();
        $this->consultations = new ArrayCollection();
        $this->habitats = new ArrayCollection();
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
            $compteRenduVet->setAdmin($this);
        }

        return $this;
    }

    public function removeCompteRenduVet(CompteRenduVet $compteRenduVet): static
    {
        if ($this->compteRenduVets->removeElement($compteRenduVet)) {
            // set the owning side to null (unless already changed)
            if ($compteRenduVet->getAdmin() === $this) {
                $compteRenduVet->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): static
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations->add($consultation);
            $consultation->setAdmin($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): static
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getAdmin() === $this) {
                $consultation->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, habitats>
     */
    public function getHabitats(): Collection
    {
        return $this->habitats;
    }

    public function addHabitat(habitats $habitat): static
    {
        if (!$this->habitats->contains($habitat)) {
            $this->habitats->add($habitat);
            $habitat->setAdmin($this);
        }

        return $this;
    }

    public function removeHabitat(habitats $habitat): static
    {
        if ($this->habitats->removeElement($habitat)) {
            // set the owning side to null (unless already changed)
            if ($habitat->getAdmin() === $this) {
                $habitat->setAdmin(null);
            }
        }

        return $this;
    }


    
}