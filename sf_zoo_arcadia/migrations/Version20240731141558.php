<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240731141558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création image, avis, services';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (
            id INT AUTO_INCREMENT NOT NULL,
            pseudo VARCHAR(25) NOT NULL,
            commentaire_avis LONGTEXT NOT NULL,
            note INT NOT NULL,
            valide TINYINT(1) NOT NULL,
            zoo_arcadia_id INT DEFAULT NULL,
            employe_id INT DEFAULT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (
            id INT AUTO_INCREMENT NOT NULL,
            nom VARCHAR(64) NOT NULL,
            image_path VARCHAR(255) NOT NULL,
            image_sub_directory VARCHAR(255) NOT NULL,
            services_id INT DEFAULT NULL,
            sous_service_id INT DEFAULT NULL,
            habitats_id INT DEFAULT NULL,
            animal_id INT DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, nom_service VARCHAR(25) NOT NULL, titre_service VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AAEF5A6C1');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP INDEX IDX_E01FBE6AAEF5A6C1 ON images');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE images');
    }
}
