<?php

namespace App\Entity;

use App\Repository\SousServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SousServiceRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'Type_Sous_Services', type: 'string')]
#[ORM\DiscriminatorMap(['sous_services' => SousService::class, 'restaurant' => Restaurant::class, 'snack' => Snack::class, 'camion_glace' => CamionGlace::class])]
abstract class SousService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('Sous_service_basic', 'services_basic')]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    #[Groups('Sous_service_basic', 'services_basic')]
    private ?string $nomSousService = null;

    #[ORM\Column(length: 255)]
    #[Groups('Sous_service_basic', 'services_basic')]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: Images::class, mappedBy: 'sousService',  cascade: ['persist', 'remove'], orphanRemoval: true, fetch: 'EAGER')]
    #[Groups('Sous_service_basic', 'services_basic')]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'sousServices')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('Sous_service_basic', 'services_basic')]
    private ?Services $service = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;
    
    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }
    
    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSousService(): ?string
    {
        return $this->nomSousService;
    }

    public function setNomSousService(string $nomSousService): static
    {
        $this->nomSousService = $nomSousService;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setSousService($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            if ($image->getSousService() === $this) {
                $image->setSousService(null);
            }
        }

        return $this;
    }


    public function getService(): ?Services
    {
        return $this->service;
    }

    public function setService(?Services $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


}
