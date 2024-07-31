<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Employe extends User
{
    #[ORM\OneToMany(targetEntity: RapportAlimentation::class, mappedBy: 'employe')]
    private Collection $rapportAlimentations;

    #[ORM\OneToMany(targetEntity: Alimentation::class, mappedBy: 'employe')]
    private Collection $alimentations;

    #[ORM\OneToMany(targetEntity: Contact::class, mappedBy: 'employe')]
    private Collection $contacts;

    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'employe')]
    private Collection $avis;


    public function __construct()
    {
        $this->rapportAlimentations = new ArrayCollection();
        $this->alimentations = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->avis = new ArrayCollection();
    }

    /**
     * @return Collection<int, RapportAlimentation>
     */
    public function getRapportAlimentations(): Collection
    {
        return $this->rapportAlimentations;
    }

    public function addRapportAlimentation(RapportAlimentation $rapportAlimentation): static
    {
        if (!$this->rapportAlimentations->contains($rapportAlimentation)) {
            $this->rapportAlimentations->add($rapportAlimentation);
            $rapportAlimentation->setEmploye($this);
        }

        return $this;
    }

    public function removeRapportAlimentation(RapportAlimentation $rapportAlimentation): static
    {
        if ($this->rapportAlimentations->removeElement($rapportAlimentation)) {
            // set the owning side to null (unless already changed)
            if ($rapportAlimentation->getEmploye() === $this) {
                $rapportAlimentation->setEmploye(null);
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
            $alimentation->setEmploye($this);
        }

        return $this;
    }

    public function removeAlimentation(Alimentation $alimentation): static
    {
        if ($this->alimentations->removeElement($alimentation)) {
            // set the owning side to null (unless already changed)
            if ($alimentation->getEmploye() === $this) {
                $alimentation->setEmploye(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setEmploye($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getEmploye() === $this) {
                $contact->setEmploye(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setEmploye($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getEmploye() === $this) {
                $avi->setEmploye(null);
            }
        }

        return $this;
    }

}