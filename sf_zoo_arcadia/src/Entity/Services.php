<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ServicesRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'Type_Services', type: 'string')]
#[ORM\DiscriminatorMap(['services' => Services::class, 'restauration' => Restauration::class, 'visite_guidee' => VisiteGuidee::class, 'petit_train' => PetitTrain::class, 'info_service' => InfoService::class])]

abstract class Services
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('services_basic')]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    #[Groups('services_basic')]
    private ?string $nomService = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('services_basic')]
    private ?string $titreService = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('services_basic')]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: Images::class, mappedBy: 'services', cascade: ['persist', 'remove', ], orphanRemoval:true)]
    #[Groups('services_basic')]
    private Collection $images;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: SousService::class, mappedBy: 'service', cascade: ['remove'], orphanRemoval: true)]
    #[Groups('services_basic')]
    private Collection $sousServices;


    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->sousServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomService(): ?string
    {
        return $this->nomService;
    }

    public function setNomService(string $nomService): static
    {
        $this->nomService = $nomService;

        return $this;
    }

    public function getTitreService(): ?string
    {
        return $this->titreService;
    }

    public function setTitreService(string $titreService): static
    {
        $this->titreService = $titreService;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
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
            $image->setServices($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            if ($image->getServices() === $this) {
                $image->setServices(null);
            }
        }

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

    /**
     * @return Collection<int, SousService>
     */
    public function getSousServices(): Collection
    {
        return $this->sousServices;
    }

    public function addSousService(SousService $sousService): static
    {
        if (!$this->sousServices->contains($sousService)) {
            $this->sousServices->add($sousService);
            $sousService->setService($this);
        }

        return $this;
    }

    public function removeSousService(SousService $sousService): static
    {
        if ($this->sousServices->removeElement($sousService)) {
            // set the owning side to null (unless already changed)
            if ($sousService->getService() === $this) {
                $sousService->setService(null);
            }
        }

        return $this;
    }
}
