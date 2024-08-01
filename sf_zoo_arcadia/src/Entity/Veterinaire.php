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
            // set the owning side to null (unless already changed)
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
            // set the owning side to null (unless already changed)
            if ($commentairesHabitat->getVeterinaire() === $this) {
                $commentairesHabitat->setVeterinaire(null);
            }
        }

        return $this;
    }

}