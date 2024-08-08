<?php

namespace App\DataFixtures;

use App\Entity\Avis;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AvisFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
    {
        $employe = $this->getReference('employe1'); 

        $avis1 = new Avis();
        $avis1->setPseudo('Visiteur1');
        $avis1->setCommentaireAvis('Super endroit, je recommande !');
        $avis1->setNote(5);
        $avis1->setValide(false);
        $avis1->setEmploye($employe);
        $avis1->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($avis1);

        $avis2 = new Avis();
        $avis2->setPseudo('Visiteur2');
        $avis2->setCommentaireAvis('Pas mal, mais peut mieux faire.');
        $avis2->setNote(3);
        $avis2->setValide(false);
        $avis2->setEmploye($employe);
        $avis2->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($avis2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            EmployeFixtures::class,
        ];
    }
}