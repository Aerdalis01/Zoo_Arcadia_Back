<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Admin extends User 
{
    #[ORM\OneToMany(targetEntity: Habitats::class, mappedBy: 'admin')]
    private Collection $habitats;

    #[ORM\OneToMany(targetEntity: Animaux::class, mappedBy: 'admin')]
    private Collection $animaux;

    #[ORM\OneToMany(targetEntity: Horaires::class, mappedBy: 'admin')]
    private Collection $horaires;


    public function __construct()
    {
        parent::__construct();
        $this->setRoles(['ROLE_ADMIN']);
    }


    /**
     * @return Collection<int, habitats>
     */
    public function getHabitats(): Collection
    {
        return $this->habitats;
    }

    public function getRoles(): array
    {
        return ['ROLE_ADMIN'];
    }
    
}