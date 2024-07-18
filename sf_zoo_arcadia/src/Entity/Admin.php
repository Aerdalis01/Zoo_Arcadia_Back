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

    #[ORM\OneToMany(targetEntity: services::class, mappedBy: 'admin')]
    private Collection $service;

    #[ORM\OneToMany(targetEntity: animal::class, mappedBy: 'admin')]
    private Collection $animal;

    #[ORM\OneToMany(targetEntity: habitats::class, mappedBy: 'admin')]
    private Collection $habitats;

    #[ORM\OneToMany(targetEntity: horaire::class, mappedBy: 'admin')]
    private Collection $horaire;

    public function __construct()
    {
        $this->compteRenduVets = new ArrayCollection();
        $this->consultations = new ArrayCollection();
        $this->service = new ArrayCollection();
        $this->animal = new ArrayCollection();
        $this->habitats = new ArrayCollection();
        $this->horaire = new ArrayCollection();
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
     * @return Collection<int, services>
     */
    public function getService(): Collection
    {
        return $this->service;
    }

    public function addService(services $service): static
    {
        if (!$this->service->contains($service)) {
            $this->service->add($service);
            $service->setAdmin($this);
        }

        return $this;
    }

    public function removeService(services $service): static
    {
        if ($this->service->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getAdmin() === $this) {
                $service->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, animal>
     */
    public function getAnimal(): Collection
    {
        return $this->animal;
    }

    public function addAnimal(animal $animal): static
    {
        if (!$this->animal->contains($animal)) {
            $this->animal->add($animal);
            $animal->setAdmin($this);
        }

        return $this;
    }

    public function removeAnimal(animal $animal): static
    {
        if ($this->animal->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getAdmin() === $this) {
                $animal->setAdmin(null);
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

    /**
     * @return Collection<int, horaire>
     */
    public function getHoraire(): Collection
    {
        return $this->horaire;
    }

    public function addHoraire(horaire $horaire): static
    {
        if (!$this->horaire->contains($horaire)) {
            $this->horaire->add($horaire);
            $horaire->setAdmin($this);
        }

        return $this;
    }

    public function removeHoraire(horaire $horaire): static
    {
        if ($this->horaire->removeElement($horaire)) {
            // set the owning side to null (unless already changed)
            if ($horaire->getAdmin() === $this) {
                $horaire->setAdmin(null);
            }
        }

        return $this;
    }
    
}