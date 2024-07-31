<?php

namespace App\Entity;

use App\Repository\CarouselRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarouselRepository::class)]
class Carousel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: CarouselSlide::class, mappedBy: 'carousel', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $carouselSlides;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?ZooArcadia $zooArcadia = null;

    public function __construct()
    {
        $this->carouselSlides = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, CarouselSlide>
     */
    public function getCarouselSlides(): Collection
    {
        return $this->carouselSlides;
    }

    public function addCarouselSlide(CarouselSlide $carouselSlide): static
    {
        if (!$this->carouselSlides->contains($carouselSlide)) {
            $this->carouselSlides->add($carouselSlide);
            $carouselSlide->setCarousel($this);
        }

        return $this;
    }

    public function removeCarouselSlide(CarouselSlide $carouselSlide): static
    {
        if ($this->carouselSlides->removeElement($carouselSlide)) {
            if ($carouselSlide->getCarousel() === $this) {
                $carouselSlide->setCarousel(null);
            }
        }

        return $this;
    }

    public function getZooArcadia(): ?ZooArcadia
    {
        return $this->zooArcadia;
    }

    public function setZooArcadia(?ZooArcadia $zooArcadia): static
    {
        $this->zooArcadia = $zooArcadia;

        return $this;
    }
}