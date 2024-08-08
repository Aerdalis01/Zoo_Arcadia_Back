<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240808124508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animaux (id INT AUTO_INCREMENT NOT NULL, habitats_id INT DEFAULT NULL, race_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, zoo_arcadia_id INT DEFAULT NULL, image_id INT DEFAULT NULL, prenom VARCHAR(25) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9ABE194D35D3C6F5 (habitats_id), INDEX IDX_9ABE194D6E59D40D (race_id), INDEX IDX_9ABE194D642B8210 (admin_id), INDEX IDX_9ABE194DFFE875C9 (zoo_arcadia_id), UNIQUE INDEX UNIQ_9ABE194D3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, zoo_arcadia_id INT DEFAULT NULL, employe_id INT DEFAULT NULL, pseudo VARCHAR(25) NOT NULL, commentaire_avis LONGTEXT NOT NULL, note INT NOT NULL, valide TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8F91ABF0FFE875C9 (zoo_arcadia_id), INDEX IDX_8F91ABF01B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carousel (id INT AUTO_INCREMENT NOT NULL, zoo_arcadia_id INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1DD74700FFE875C9 (zoo_arcadia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carousel_slide (id INT AUTO_INCREMENT NOT NULL, carousel_id INT DEFAULT NULL, image_large VARCHAR(255) NOT NULL, image_medium VARCHAR(255) NOT NULL, image_small VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_BD7937A4C1CE5B98 (carousel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires_habitat (id INT AUTO_INCREMENT NOT NULL, veterinaire_id INT DEFAULT NULL, habitat_id INT DEFAULT NULL, commentaire_habitat VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D9ABEAFE5C80924 (veterinaire_id), INDEX IDX_D9ABEAFEAFFE2D26 (habitat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte_rendu_vet (id INT AUTO_INCREMENT NOT NULL, veterinaire_id INT DEFAULT NULL, animaux_id INT DEFAULT NULL, commentaire_etat VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_96F75B8A5C80924 (veterinaire_id), INDEX IDX_96F75B8AA9DAECAA (animaux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_964685A68E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, employe_id INT DEFAULT NULL, email VARCHAR(64) NOT NULL, titre VARCHAR(25) NOT NULL, commentaire VARCHAR(255) NOT NULL, send_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4C62E6381B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitats (id INT AUTO_INCREMENT NOT NULL, zoo_arcadia_id INT NOT NULL, admin_id INT DEFAULT NULL, nom VARCHAR(25) NOT NULL, description LONGTEXT NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B5E492F3FFE875C9 (zoo_arcadia_id), INDEX IDX_B5E492F3642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaires (id INT AUTO_INCREMENT NOT NULL, info_service_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, jour VARCHAR(25) NOT NULL, heure_ouverture_zoo TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', heure_fermeture_zoo TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', horaires_services JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_39B7118FB599954A (info_service_id), INDEX IDX_39B7118F642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, services_id INT DEFAULT NULL, sous_service_id INT NOT NULL, habitats_id INT DEFAULT NULL, animal_id INT DEFAULT NULL, nom VARCHAR(64) NOT NULL, image_path VARCHAR(255) NOT NULL, image_sub_directory VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6AAEF5A6C1 (services_id), INDEX IDX_E01FBE6AB24FC0C (sous_service_id), INDEX IDX_E01FBE6A35D3C6F5 (habitats_id), UNIQUE INDEX UNIQ_E01FBE6A8E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE races (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport_alimentation (id INT AUTO_INCREMENT NOT NULL, employe_id INT DEFAULT NULL, animal_id INT DEFAULT NULL, date DATE NOT NULL, heure TIME NOT NULL, nourriture VARCHAR(255) NOT NULL, quantite DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2A93B0331B65292 (employe_id), INDEX IDX_2A93B0338E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, employe_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, zoo_arcadia_id INT DEFAULT NULL, carte_zoo_id INT DEFAULT NULL, nom_service VARCHAR(25) NOT NULL, titre_service VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', Type_Services VARCHAR(255) NOT NULL, INDEX IDX_7332E1691B65292 (employe_id), INDEX IDX_7332E169642B8210 (admin_id), INDEX IDX_7332E169FFE875C9 (zoo_arcadia_id), INDEX IDX_7332E169ECB8F4DE (carte_zoo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_service (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, nom_sous_service VARCHAR(25) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', Type_Sous_Services VARCHAR(255) NOT NULL, INDEX IDX_C294E29FED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(25) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', email VARCHAR(255) DEFAULT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zoo_arcadia (id INT AUTO_INCREMENT NOT NULL, carousel_id INT DEFAULT NULL, nom VARCHAR(25) NOT NULL, adresse VARCHAR(75) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_AF4DDFC5C1CE5B98 (carousel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194D35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194D6E59D40D FOREIGN KEY (race_id) REFERENCES races (id)');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194D642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194DFFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194D3DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF01B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE carousel ADD CONSTRAINT FK_1DD74700FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('ALTER TABLE carousel_slide ADD CONSTRAINT FK_BD7937A4C1CE5B98 FOREIGN KEY (carousel_id) REFERENCES carousel (id)');
        $this->addSql('ALTER TABLE commentaires_habitat ADD CONSTRAINT FK_D9ABEAFE5C80924 FOREIGN KEY (veterinaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaires_habitat ADD CONSTRAINT FK_D9ABEAFEAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE compte_rendu_vet ADD CONSTRAINT FK_96F75B8A5C80924 FOREIGN KEY (veterinaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE compte_rendu_vet ADD CONSTRAINT FK_96F75B8AA9DAECAA FOREIGN KEY (animaux_id) REFERENCES animaux (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A68E962C16 FOREIGN KEY (animal_id) REFERENCES animaux (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6381B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F3FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F3642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE horaires ADD CONSTRAINT FK_39B7118FB599954A FOREIGN KEY (info_service_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE horaires ADD CONSTRAINT FK_39B7118F642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AAEF5A6C1 FOREIGN KEY (services_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AB24FC0C FOREIGN KEY (sous_service_id) REFERENCES sous_service (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A8E962C16 FOREIGN KEY (animal_id) REFERENCES animaux (id)');
        $this->addSql('ALTER TABLE rapport_alimentation ADD CONSTRAINT FK_2A93B0331B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rapport_alimentation ADD CONSTRAINT FK_2A93B0338E962C16 FOREIGN KEY (animal_id) REFERENCES animaux (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E1691B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169ECB8F4DE FOREIGN KEY (carte_zoo_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE sous_service ADD CONSTRAINT FK_C294E29FED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE zoo_arcadia ADD CONSTRAINT FK_AF4DDFC5C1CE5B98 FOREIGN KEY (carousel_id) REFERENCES carousel (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194D35D3C6F5');
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194D6E59D40D');
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194D642B8210');
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194DFFE875C9');
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194D3DA5256D');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0FFE875C9');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF01B65292');
        $this->addSql('ALTER TABLE carousel DROP FOREIGN KEY FK_1DD74700FFE875C9');
        $this->addSql('ALTER TABLE carousel_slide DROP FOREIGN KEY FK_BD7937A4C1CE5B98');
        $this->addSql('ALTER TABLE commentaires_habitat DROP FOREIGN KEY FK_D9ABEAFE5C80924');
        $this->addSql('ALTER TABLE commentaires_habitat DROP FOREIGN KEY FK_D9ABEAFEAFFE2D26');
        $this->addSql('ALTER TABLE compte_rendu_vet DROP FOREIGN KEY FK_96F75B8A5C80924');
        $this->addSql('ALTER TABLE compte_rendu_vet DROP FOREIGN KEY FK_96F75B8AA9DAECAA');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A68E962C16');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6381B65292');
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F3FFE875C9');
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F3642B8210');
        $this->addSql('ALTER TABLE horaires DROP FOREIGN KEY FK_39B7118FB599954A');
        $this->addSql('ALTER TABLE horaires DROP FOREIGN KEY FK_39B7118F642B8210');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AAEF5A6C1');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AB24FC0C');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A35D3C6F5');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A8E962C16');
        $this->addSql('ALTER TABLE rapport_alimentation DROP FOREIGN KEY FK_2A93B0331B65292');
        $this->addSql('ALTER TABLE rapport_alimentation DROP FOREIGN KEY FK_2A93B0338E962C16');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E1691B65292');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169642B8210');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169FFE875C9');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169ECB8F4DE');
        $this->addSql('ALTER TABLE sous_service DROP FOREIGN KEY FK_C294E29FED5CA9E6');
        $this->addSql('ALTER TABLE zoo_arcadia DROP FOREIGN KEY FK_AF4DDFC5C1CE5B98');
        $this->addSql('DROP TABLE animaux');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE carousel');
        $this->addSql('DROP TABLE carousel_slide');
        $this->addSql('DROP TABLE commentaires_habitat');
        $this->addSql('DROP TABLE compte_rendu_vet');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE habitats');
        $this->addSql('DROP TABLE horaires');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE races');
        $this->addSql('DROP TABLE rapport_alimentation');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE sous_service');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE zoo_arcadia');
    }
}
