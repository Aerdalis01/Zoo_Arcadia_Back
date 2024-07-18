<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToMany(targetEntity: animal::class, inversedBy: 'consultations')]
    private Collection $animal;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    private ?admin $admin = null;

    public function __construct()
    {
        $this->animal = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

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
        }

        return $this;
    }

    public function removeAnimal(animal $animal): static
    {
        $this->animal->removeElement($animal);

        return $this;
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
