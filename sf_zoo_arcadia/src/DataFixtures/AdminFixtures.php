<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Restaurant;
use App\Entity\ZooArcadia;
use App\Entity\Races;
use App\Entity\Restauration;
use App\Entity\Employe;
use App\Entity\Veterinaire;
use App\Entity\Habitats;
use App\Entity\Animaux;
use App\Entity\Horaires;
use App\Entity\InfoService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class AdminFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        var_dump('Starting AdminFixtures load'); // Debug

        // Récupérer l'instance existante de ZooArcadia
        $zooArcadiaRepository = $manager->getRepository(ZooArcadia::class);
        $zooArcadia = $zooArcadiaRepository->findOneBy(['nom' => 'Zoo Arcadia']);
        
        if (!$zooArcadia) {
            throw new \Exception('ZooArcadia non trouvé. Assurez-vous qu\'il existe dans la base de données.');
        }

        // Récupérer l'administrateur existant
        $adminRepository = $manager->getRepository(Admin::class);
        $admin = $adminRepository->findOneBy(['email' => 'josearcadia98@gmail.com']);

        if (!$admin) {
            throw new \Exception('Administrateur non trouvé. Assurez-vous que AdminInitializer a été exécuté.');
        }

        $restaurationRepository = $manager->getRepository(Restauration::class);
        $restauration = $restaurationRepository->findOneBy(['nomService' => 'Restauration']);

        if (!$restauration) {
            throw new \Exception('Service Restauration non trouvé.');
        }

        // Création des horaires
        $horaireVisiteGuidee = new Horaires();
        $horaireVisiteGuidee->setHorairesServices(["09:00 - 11:00", "14:00 - 16:00"]);
        $horaireVisiteGuidee->setTitreHoraire('Horaire Visite Guidée');
        $horaireVisiteGuidee->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($horaireVisiteGuidee);

        $horairePetitTrain = new Horaires();
        $horairePetitTrain->setHorairesServices(["09:30 - 11:30", "14:30 - 16:30"]);
        $horairePetitTrain->setTitreHoraire('Horaire Petit Train');
        $horairePetitTrain->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($horairePetitTrain);

        $this->setReference("horaire_visite_guidee", $horaireVisiteGuidee);
        $this->setReference("horaire_petit_train", $horairePetitTrain);

        // Création du sous-service InfoService pour Visite Guidée
        $infoService = new InfoService();
        $infoService->setNomService('Horaires');
        $infoService->setCreatedAt(new \DateTimeImmutable());
        $infoService->addHoraire($horaireVisiteGuidee);
        $infoService->addHoraire($horairePetitTrain);
        $manager->persist($infoService);

        $manager->flush();
        
        $felide = new Races('Félidé');
        $felide->setNom('Félidé');
        $manager->persist($felide);

        $manager->flush();
        
        $lion = new Animaux();
        $lion->setPrenom('Simba');
        $lion->setRace($felide); 
        $lion->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($lion);
        
        $manager->flush();

        // Création des employés et vétérinaires
        for ($i = 1; $i <= 5; $i++) {
            $sousService = new Restaurant();
            $sousService->setNomSousService("Restaurant");
            $sousService->setDescription('Super restaurant');
            $sousService->setService($restauration);
            $sousService->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($sousService);
            
            

            $employe = new Employe();
            $employe->setUsername("employe$i");
            $employe->setEmail("employe$i@example.com");
            $employe->setPassword($this->passwordHasher->hashPassword($employe, 'password'));
            $employe->setRoles(['ROLE_EMPLOYE']);
            $employe->setCreatedAt(new \DateTimeImmutable());
            var_dump($employe->getRoles()); // Debug pour vérifier les rôles
            $manager->persist($employe);

            $veterinaire = new Veterinaire();
            $veterinaire->setUsername("veterinaire$i");
            $veterinaire->setEmail("veterinaire$i@example.com");
            $veterinaire->setPassword($this->passwordHasher->hashPassword($veterinaire, 'password'));
            $veterinaire->setRoles(['ROLE_VETERINAIRE']);
            $veterinaire->setCreatedAt(new \DateTimeImmutable());
            var_dump($veterinaire->getRoles()); // Debug pour vérifier les rôles
            $manager->persist($veterinaire);

            if ($i === 1) {
                $this->addReference('veterinaire1', $veterinaire);
            }


            
            
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            ZooArcadiaFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['group_admin'];
    }
}
