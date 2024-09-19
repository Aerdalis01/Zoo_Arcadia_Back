<?php

namespace App\Entity;

use App\Repository\RacesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RacesRepository::class)]
class Races
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('races_basic')]
    private ?int $id = null;

    #[Groups('races_basic')]
    #[ORM\Column(length: 25)]
    private ?string $nom = null;

    #[ORM\OneToMany(targetEntity: Animaux::class, mappedBy: 'race')]
    #[Groups('races_animaux')]
    private Collection $animaux;

    public function __construct(string $nom)
    {
        $this->nom = $nom;
        $this->animaux = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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
            $animaux->setRace($this);
        }

        return $this;
    }

    public function removeAnimaux(Animaux $animaux): static
    {
        if ($this->animaux->removeElement($animaux)) {
            if ($animaux->getRace() === $this) {
                $animaux->setRace(null);
            }
        }

        return $this;
    }


}
