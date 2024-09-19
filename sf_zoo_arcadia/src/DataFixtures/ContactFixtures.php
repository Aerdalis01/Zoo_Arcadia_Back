<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ContactFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $employe = $this->getReference('employe1');

        $contact1 = new Contact();
        $contact1->setTitre('Titre1');
        $contact1->setEmail('contact1@example.com');
        $contact1->setSendAt(new \DateTimeImmutable());
        $contact1->setCommentaire('Commentaire de contact 1');
        $contact1->setEmploye($employe);
        $manager->persist($contact1);

        $contact2 = new Contact();
        $contact2->setTitre('Titre2');
        $contact2->setEmail('contact2@example.com');
        $contact2->setSendAt(new \DateTimeImmutable());
        $contact2->setCommentaire('Commentaire de contact 2');
        $contact2->setEmploye($employe);
        $manager->persist($contact2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            EmployeFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['group_contact'];
    }
}
