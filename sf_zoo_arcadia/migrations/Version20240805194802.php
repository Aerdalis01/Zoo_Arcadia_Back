<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240805194802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alimentation (id INT AUTO_INCREMENT NOT NULL, vétérinaire_id INT DEFAULT NULL, compte_rendu_vet_id INT DEFAULT NULL, employe_id INT DEFAULT NULL, date DATE NOT NULL, time TIME NOT NULL, nourriture VARCHAR(255) NOT NULL, quantite DOUBLE PRECISION NOT NULL, INDEX IDX_8E65DFA01186E1FE (vétérinaire_id), INDEX IDX_8E65DFA0F075B8D0 (compte_rendu_vet_id), INDEX IDX_8E65DFA01B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte_rendu_vet (id INT AUTO_INCREMENT NOT NULL, veterinaire_id INT DEFAULT NULL, animaux_id INT DEFAULT NULL, commentaire_etat VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_96F75B8A5C80924 (veterinaire_id), INDEX IDX_96F75B8AA9DAECAA (animaux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_964685A68E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, employe_id INT DEFAULT NULL, email VARCHAR(64) NOT NULL, titre VARCHAR(25) NOT NULL, commentaire VARCHAR(255) NOT NULL, send_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4C62E6381B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaires (id INT AUTO_INCREMENT NOT NULL, info_service_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, jour VARCHAR(25) NOT NULL, heure_ouverture JSON NOT NULL COMMENT \'(DC2Type:json)\', heure_fermeture JSON NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_39B7118FB599954A (info_service_id), INDEX IDX_39B7118F642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport_alimentation (id INT AUTO_INCREMENT NOT NULL, employe_id INT DEFAULT NULL, animal_id INT DEFAULT NULL, date DATE NOT NULL, heure TIME NOT NULL, nourriture VARCHAR(255) NOT NULL, quantite DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2A93B0331B65292 (employe_id), INDEX IDX_2A93B0338E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alimentation ADD CONSTRAINT FK_8E65DFA01186E1FE FOREIGN KEY (vétérinaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE alimentation ADD CONSTRAINT FK_8E65DFA0F075B8D0 FOREIGN KEY (compte_rendu_vet_id) REFERENCES compte_rendu_vet (id)');
        $this->addSql('ALTER TABLE alimentation ADD CONSTRAINT FK_8E65DFA01B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE compte_rendu_vet ADD CONSTRAINT FK_96F75B8A5C80924 FOREIGN KEY (veterinaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE compte_rendu_vet ADD CONSTRAINT FK_96F75B8AA9DAECAA FOREIGN KEY (animaux_id) REFERENCES animaux (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A68E962C16 FOREIGN KEY (animal_id) REFERENCES animaux (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6381B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE horaires ADD CONSTRAINT FK_39B7118FB599954A FOREIGN KEY (info_service_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE horaires ADD CONSTRAINT FK_39B7118F642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rapport_alimentation ADD CONSTRAINT FK_2A93B0331B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rapport_alimentation ADD CONSTRAINT FK_2A93B0338E962C16 FOREIGN KEY (animal_id) REFERENCES animaux (id)');
        $this->addSql('ALTER TABLE animaux ADD habitats_id INT DEFAULT NULL, ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194D35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194D3DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('CREATE INDEX IDX_9ABE194D35D3C6F5 ON animaux (habitats_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9ABE194D3DA5256D ON animaux (image_id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF01B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0FFE875C9 ON avis (zoo_arcadia_id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF01B65292 ON avis (employe_id)');
        $this->addSql('ALTER TABLE carousel ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F3FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F3642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B5E492F3FFE875C9 ON habitats (zoo_arcadia_id)');
        $this->addSql('CREATE INDEX IDX_B5E492F3642B8210 ON habitats (admin_id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AAEF5A6C1 FOREIGN KEY (services_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AB24FC0C FOREIGN KEY (sous_service_id) REFERENCES sous_service (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A8E962C16 FOREIGN KEY (animal_id) REFERENCES animaux (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AAEF5A6C1 ON images (services_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AB24FC0C ON images (sous_service_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A35D3C6F5 ON images (habitats_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E01FBE6A8E962C16 ON images (animal_id)');
        $this->addSql('DROP INDEX IDX_ROLE ON user');
        $this->addSql('ALTER TABLE zoo_arcadia ADD CONSTRAINT FK_AF4DDFC5C1CE5B98 FOREIGN KEY (carousel_id) REFERENCES carousel (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF4DDFC5C1CE5B98 ON zoo_arcadia (carousel_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alimentation DROP FOREIGN KEY FK_8E65DFA01186E1FE');
        $this->addSql('ALTER TABLE alimentation DROP FOREIGN KEY FK_8E65DFA0F075B8D0');
        $this->addSql('ALTER TABLE alimentation DROP FOREIGN KEY FK_8E65DFA01B65292');
        $this->addSql('ALTER TABLE compte_rendu_vet DROP FOREIGN KEY FK_96F75B8A5C80924');
        $this->addSql('ALTER TABLE compte_rendu_vet DROP FOREIGN KEY FK_96F75B8AA9DAECAA');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A68E962C16');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6381B65292');
        $this->addSql('ALTER TABLE horaires DROP FOREIGN KEY FK_39B7118FB599954A');
        $this->addSql('ALTER TABLE horaires DROP FOREIGN KEY FK_39B7118F642B8210');
        $this->addSql('ALTER TABLE rapport_alimentation DROP FOREIGN KEY FK_2A93B0331B65292');
        $this->addSql('ALTER TABLE rapport_alimentation DROP FOREIGN KEY FK_2A93B0338E962C16');
        $this->addSql('DROP TABLE alimentation');
        $this->addSql('DROP TABLE compte_rendu_vet');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE horaires');
        $this->addSql('DROP TABLE rapport_alimentation');
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194D35D3C6F5');
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194D3DA5256D');
        $this->addSql('DROP INDEX IDX_9ABE194D35D3C6F5 ON animaux');
        $this->addSql('DROP INDEX UNIQ_9ABE194D3DA5256D ON animaux');
        $this->addSql('ALTER TABLE animaux DROP habitats_id, DROP image_id');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0FFE875C9');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF01B65292');
        $this->addSql('DROP INDEX IDX_8F91ABF0FFE875C9 ON avis');
        $this->addSql('DROP INDEX IDX_8F91ABF01B65292 ON avis');
        $this->addSql('ALTER TABLE carousel DROP updated_at');
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F3FFE875C9');
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F3642B8210');
        $this->addSql('DROP INDEX IDX_B5E492F3FFE875C9 ON habitats');
        $this->addSql('DROP INDEX IDX_B5E492F3642B8210 ON habitats');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AAEF5A6C1');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AB24FC0C');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A35D3C6F5');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A8E962C16');
        $this->addSql('DROP INDEX IDX_E01FBE6AAEF5A6C1 ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6AB24FC0C ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6A35D3C6F5 ON images');
        $this->addSql('DROP INDEX UNIQ_E01FBE6A8E962C16 ON images');
        $this->addSql('CREATE INDEX IDX_ROLE ON user (role)');
        $this->addSql('ALTER TABLE zoo_arcadia DROP FOREIGN KEY FK_AF4DDFC5C1CE5B98');
        $this->addSql('DROP INDEX UNIQ_AF4DDFC5C1CE5B98 ON zoo_arcadia');
    }
}
