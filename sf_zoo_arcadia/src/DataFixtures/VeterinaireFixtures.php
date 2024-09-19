<?php

namespace App\DataFixtures;

use App\Entity\Veterinaire;
use App\Entity\CompteRenduVet;
use App\Entity\CommentairesHabitat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class VeterinaireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Récupérer le vétérinaire1 créé par AdminFixtures
        /** @var Veterinaire $veterinaire1 */
        $veterinaire1 = $this->getReference('veterinaire1');

        // Récupérer un rapport d'alimentation existant
        $rapportAlimentation = $this->getReference('rapport_alimentation_1');

        // Création d'un compte rendu pour veterinaire1
        $compteRendu = new CompteRenduVet();
        $compteRendu->setCommentaireEtat("Etat de l'animal bon");
        $compteRendu->setCreatedAt(new \DateTimeImmutable());
        $compteRendu->setVeterinaire($veterinaire1);

        // Lier le compte rendu à l'animal via le rapport d'alimentation (par l'intermédiaire du formulaire)
        $compteRendu->setAnimaux($rapportAlimentation->getAnimal());

        // Persist du compte rendu
        $manager->persist($compteRendu);

        // Création d'un commentaire sur l'habitat pour veterinaire1
        $commentaire = new CommentairesHabitat();
        $commentaire->setCommentaireHabitat("Propreté à améliorer pour le bien-être des animaux");
        $commentaire->setCreatedAt(new \DateTimeImmutable());
        $commentaire->setVeterinaire($veterinaire1);

        // Récupérer un habitat existant pour l'associer au commentaire
        $habitat2 = $this->getReference("habitat_savane");
        $commentaire->setHabitat($habitat2);

        // Persist du commentaire
        $manager->persist($commentaire);

        // Enregistrement dans la base de données
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AdminFixtures::class, 
            HabitatsFixtures::class,
            RapportAlimentationFixtures::class, // Ajouter la dépendance à RapportAlimentationFixtures
        ];
    }
}
