<?php

namespace App\DataFixtures;

use App\Entity\Restauration;
use App\Entity\VisiteGuidee;
use App\Entity\PetitTrain;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ServicesFixtures extends Fixture implements  FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $serviceRestauration = new Restauration();
        $serviceRestauration->setNomService('Restauration');
        $serviceRestauration->setTitreService('Une envie de grignoter ou une petite faim?');
        $serviceRestauration->setDescription(null);
        $serviceRestauration->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($serviceRestauration);
        $this->addReference('Restauration', $serviceRestauration);

        $serviceVisiteGuidee = new VisiteGuidee();
        $serviceVisiteGuidee->setNomService('VisiteGuidée');
        $serviceVisiteGuidee->setTitreService('Suivez le guide !!');
        $serviceVisiteGuidee->setDescription('Description du service 2');
        $serviceVisiteGuidee->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($serviceVisiteGuidee);
        $this->addReference('VisiteGuidee', $serviceVisiteGuidee);

        $petitTrain = new PetitTrain();
        $petitTrain->setNomService('Petit Train');
        $petitTrain->setTitreService('Découvrez le zoo autrement.');
        $petitTrain->setDescription('Description du petit train');
        $petitTrain->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($petitTrain);
        $this->addReference('PetitTrain', $petitTrain);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group_services'];
    }

}
