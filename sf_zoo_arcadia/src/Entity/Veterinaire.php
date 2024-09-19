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

    #[ORM\OneToMany(targetEntity: CommentairesHabitat::class, mappedBy: 'veterinaire')]
    private Collection $commentairesHabitats;

    public function __construct()
    {
        parent::__construct();
        $this->setRoles(['ROLE_VETERINAIRE']);
        $this->compteRenduVets= new ArrayCollection();
        $this->commentairesHabitats = new ArrayCollection();
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
            if ($compteRenduVet->getVeterinaire() === $this) {
                $compteRenduVet->setVeterinaire(null);
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
            $commentairesHabitat->setVeterinaire($this);
        }

        return $this;
    }

    public function removeCommentairesHabitat(CommentairesHabitat $commentairesHabitat): static
    {
        if ($this->commentairesHabitats->removeElement($commentairesHabitat)) {
            if ($commentairesHabitat->getVeterinaire() === $this) {
                $commentairesHabitat->setVeterinaire(null);
            }
        }

        return $this;
    }

}