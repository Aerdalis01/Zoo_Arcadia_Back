<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Admin extends User
{
    #[ORM\OneToMany(targetEntity: habitats::class, mappedBy: 'admin')]
    private Collection $habitats;

    #[ORM\OneToMany(targetEntity: Services::class, mappedBy: 'admin')]
    private Collection $services;

    #[ORM\OneToMany(targetEntity: Animaux::class, mappedBy: 'admin')]
    private Collection $animaux;

    #[ORM\OneToMany(targetEntity: Horaires::class, mappedBy: 'admin')]
    private Collection $horaires;


    public function __construct()
    {
        $this->habitats = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->animaux = new ArrayCollection();
        $this->horaires = new ArrayCollection();
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
     * @return Collection<int, Services>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Services $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setAdmin($this);
        }

        return $this;
    }

    public function removeService(Services $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getAdmin() === $this) {
                $service->setAdmin(null);
            }
        }

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
            $animaux->setAdmin($this);
        }

        return $this;
    }

    public function removeAnimaux(Animaux $animaux): static
    {
        if ($this->animaux->removeElement($animaux)) {
            // set the owning side to null (unless already changed)
            if ($animaux->getAdmin() === $this) {
                $animaux->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Horaires>
     */
    public function getHoraires(): Collection
    {
        return $this->horaires;
    }

    public function addHoraire(Horaires $horaire): static
    {
        if (!$this->horaires->contains($horaire)) {
            $this->horaires->add($horaire);
            $horaire->setAdmin($this);
        }

        return $this;
    }

    public function removeHoraire(Horaires $horaire): static
    {
        if ($this->horaires->removeElement($horaire)) {
            // set the owning side to null (unless already changed)
            if ($horaire->getAdmin() === $this) {
                $horaire->setAdmin(null);
            }
        }

        return $this;
    }


    
}