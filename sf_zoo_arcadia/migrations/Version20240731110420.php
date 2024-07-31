<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240731110420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alimentation (id INT AUTO_INCREMENT NOT NULL, vétérinaire_id INT DEFAULT NULL, compte_rendu_vet_id INT DEFAULT NULL, employe_id INT DEFAULT NULL, date DATE NOT NULL, time TIME NOT NULL, nourriture VARCHAR(255) NOT NULL, quantite DOUBLE PRECISION NOT NULL, INDEX IDX_8E65DFA01186E1FE (vétérinaire_id), INDEX IDX_8E65DFA0F075B8D0 (compte_rendu_vet_id), INDEX IDX_8E65DFA01B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultation_animal (consultation_id INT NOT NULL, animal_id INT NOT NULL, INDEX IDX_B606B43262FF6CDF (consultation_id), INDEX IDX_B606B4328E962C16 (animal_id), PRIMARY KEY(consultation_id, animal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alimentation ADD CONSTRAINT FK_8E65DFA01186E1FE FOREIGN KEY (vétérinaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE alimentation ADD CONSTRAINT FK_8E65DFA0F075B8D0 FOREIGN KEY (compte_rendu_vet_id) REFERENCES compte_rendu_vet (id)');
        $this->addSql('ALTER TABLE alimentation ADD CONSTRAINT FK_8E65DFA01B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consultation_animal ADD CONSTRAINT FK_B606B43262FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consultation_animal ADD CONSTRAINT FK_B606B4328E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire_habitats DROP FOREIGN KEY FK_47F55A2F35D3C6F5');
        $this->addSql('ALTER TABLE commentaire_habitats DROP FOREIGN KEY FK_47F55A2F5C80924');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169642B8210');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169FFE875C9');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E1691B65292');
        $this->addSql('ALTER TABLE sous_services DROP FOREIGN KEY FK_7B7CD53CAEF5A6C1');
        $this->addSql('ALTER TABLE sous_services DROP FOREIGN KEY FK_7B7CD53C3DA5256D');
        $this->addSql('DROP TABLE commentaire_habitats');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE sous_services');
        $this->addSql('ALTER TABLE avis ADD text LONGTEXT NOT NULL, DROP commentaire, DROP created_at, DROP validate_at, CHANGE is_valid approuve TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire_habitats (id INT AUTO_INCREMENT NOT NULL, veterinaire_id INT DEFAULT NULL, habitats_id INT DEFAULT NULL, commentaire_habitats VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', upadated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_47F55A2F35D3C6F5 (habitats_id), INDEX IDX_47F55A2F5C80924 (veterinaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, zoo_arcadia_id INT DEFAULT NULL, employe_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', nom VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_7332E169642B8210 (admin_id), INDEX IDX_7332E169FFE875C9 (zoo_arcadia_id), INDEX IDX_7332E1691B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sous_services (id INT AUTO_INCREMENT NOT NULL, services_id INT DEFAULT NULL, image_id INT DEFAULT NULL, nom VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, menu LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_7B7CD53C3DA5256D (image_id), INDEX IDX_7B7CD53CAEF5A6C1 (services_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commentaire_habitats ADD CONSTRAINT FK_47F55A2F35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE commentaire_habitats ADD CONSTRAINT FK_47F55A2F5C80924 FOREIGN KEY (veterinaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E1691B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sous_services ADD CONSTRAINT FK_7B7CD53CAEF5A6C1 FOREIGN KEY (services_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE sous_services ADD CONSTRAINT FK_7B7CD53C3DA5256D FOREIGN KEY (image_id) REFERENCES image_zoo (id)');
        $this->addSql('ALTER TABLE alimentation DROP FOREIGN KEY FK_8E65DFA01186E1FE');
        $this->addSql('ALTER TABLE alimentation DROP FOREIGN KEY FK_8E65DFA0F075B8D0');
        $this->addSql('ALTER TABLE alimentation DROP FOREIGN KEY FK_8E65DFA01B65292');
        $this->addSql('ALTER TABLE consultation_animal DROP FOREIGN KEY FK_B606B43262FF6CDF');
        $this->addSql('ALTER TABLE consultation_animal DROP FOREIGN KEY FK_B606B4328E962C16');
        $this->addSql('DROP TABLE alimentation');
        $this->addSql('DROP TABLE consultation_animal');
        $this->addSql('ALTER TABLE avis ADD commentaire VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD validate_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP text, CHANGE approuve is_valid TINYINT(1) NOT NULL');
    }
}
