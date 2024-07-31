<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class InfoService extends Services
{
    #[ORM\OneToMany(targetEntity: Horaires::class, mappedBy: 'infoService')]
    private Collection $horaires;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Images $carteZoo = null;



    public function __construct()
    {
        parent::__construct();
        $this->horaires = new ArrayCollection();
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
            $horaire->setInfoService($this);
        }

        return $this;
    }

    public function removeHoraire(Horaires $horaire): static
    {
        if ($this->horaires->removeElement($horaire)) {
            // set the owning side to null (unless already changed)
            if ($horaire->getInfoService() === $this) {
                $horaire->setInfoService(null);
            }
        }

        return $this;
    }

    public function getCarteZoo(): ?Images
    {
        return $this->carteZoo;
    }

    public function setCarteZoo(?Images $carteZoo): static
    {
        $this->carteZoo = $carteZoo;

        return $this;
    }
    public function getCarteZooPath(): ?string
    {
        return $this->carteZoo ? $this->carteZoo->getImagePath() : null;
    }
}