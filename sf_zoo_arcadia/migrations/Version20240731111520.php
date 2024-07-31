<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240731111520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F5541CA27');
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F35541CA27');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F6E59D40D');
        $this->addSql('CREATE TABLE horaires (id INT AUTO_INCREMENT NOT NULL, jour VARCHAR(25) NOT NULL, heure_ouverture JSON NOT NULL COMMENT \'(DC2Type:json)\', heure_fermeture JSON NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(64) NOT NULL, image_path VARCHAR(255) NOT NULL, image_sub_directory VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE races (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE horaire DROP FOREIGN KEY FK_BBC83DB6642B8210');
        $this->addSql('ALTER TABLE horaire DROP FOREIGN KEY FK_BBC83DB6FFE875C9');
        $this->addSql('ALTER TABLE image_zoo DROP FOREIGN KEY FK_C1A5EF6635D3C6F5');
        $this->addSql('DROP TABLE horaire');
        $this->addSql('DROP TABLE image_zoo');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP INDEX IDX_6AAB231F6E59D40D ON animal');
        $this->addSql('DROP INDEX UNIQ_6AAB231F5541CA27 ON animal');
        $this->addSql('ALTER TABLE animal DROP race_id, DROP image_zoo_id');
        $this->addSql('DROP INDEX UNIQ_B5E492F35541CA27 ON habitats');
        $this->addSql('ALTER TABLE habitats DROP image_zoo_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE horaire (id INT AUTO_INCREMENT NOT NULL, zoo_arcadia_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, jour VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, heure_ouverture JSON NOT NULL COMMENT \'(DC2Type:json)\', heure_fermeture JSON NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_BBC83DB6642B8210 (admin_id), INDEX IDX_BBC83DB6FFE875C9 (zoo_arcadia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE image_zoo (id INT AUTO_INCREMENT NOT NULL, habitats_id INT DEFAULT NULL, nom VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image_path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, imagesub_directory VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_C1A5EF6635D3C6F5 (habitats_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE horaire ADD CONSTRAINT FK_BBC83DB6642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE horaire ADD CONSTRAINT FK_BBC83DB6FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('ALTER TABLE image_zoo ADD CONSTRAINT FK_C1A5EF6635D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('DROP TABLE horaires');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE races');
        $this->addSql('ALTER TABLE animal ADD race_id INT DEFAULT NULL, ADD image_zoo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F6E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F5541CA27 FOREIGN KEY (image_zoo_id) REFERENCES image_zoo (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F6E59D40D ON animal (race_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AAB231F5541CA27 ON animal (image_zoo_id)');
        $this->addSql('ALTER TABLE habitats ADD image_zoo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F35541CA27 FOREIGN KEY (image_zoo_id) REFERENCES image_zoo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B5E492F35541CA27 ON habitats (image_zoo_id)');
    }
}
