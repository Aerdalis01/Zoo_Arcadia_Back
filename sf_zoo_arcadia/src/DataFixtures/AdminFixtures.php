<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Service\HabitatsService;
use App\Service\ServicesService;
use App\Service\AnimauxService;
use App\Service\HorairesService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AdminFixtures extends Fixture implements DependentFixtureInterface
{
    private $habitatsService;
    private $servicesService;
    private $animauxService;
    private $horairesService;

    public function __construct(
        HabitatsService $habitatsService,

        AnimauxService $animauxService,
        HorairesService $horairesService
    ) {
        $this->habitatsService = $habitatsService;

        $this->animauxService = $animauxService;
        $this->horairesService = $horairesService;
    }

    public function load(ObjectManager $manager): void
    {
        // Assuming the admin is already in the database
        $admin = $manager->getRepository(Admin::class)->findOneBy(['email' => 'admin@example.com']);

        if (!$admin) {
            throw new \Exception('Admin not found. Please make sure an Admin with email admin@example.com exists.');
        }

        // Creating Habitats
        $this->habitatsService->createHabitat('Savane', 'Habitat pour les animaux de la savane', null, $admin);
        $this->habitatsService->createHabitat('Marais', 'Habitat pour les animaux du marais', null, $admin);

        // Creating Services
        $this->servicesService->createService('Restauration', 'une petite faim?', null, $admin);
        $this->servicesService->createService('Visite guidée', 'Suivez le guide', null, $admin);

        // Creating Animaux
        $this->animauxService->createAnimal('René le cerf', 'Cervidé', null, null, null, null, $admin);
        $this->animauxService->createAnimal('Basile l\'éléphant', 'Éléphantidé', null, null, null, null, $admin);

        // Creating Horaires


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class, // Ensure that UserFixtures runs before this fixture
        ];
    }
}
