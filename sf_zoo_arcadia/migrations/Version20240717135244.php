<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240717135244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE habitats (id INT AUTO_INCREMENT NOT NULL, zoo_arcadia_id INT DEFAULT NULL, nom VARCHAR(25) NOT NULL, description LONGTEXT NOT NULL, image JSON NOT NULL COMMENT \'(DC2Type:json)\', creatd_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B5E492F3FFE875C9 (zoo_arcadia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_zoo (id INT AUTO_INCREMENT NOT NULL, zoo_arcadia_id INT DEFAULT NULL, titre VARCHAR(64) NOT NULL, image JSON NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_C1A5EF66FFE875C9 (zoo_arcadia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F3FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('ALTER TABLE image_zoo ADD CONSTRAINT FK_C1A5EF66FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F3FFE875C9');
        $this->addSql('ALTER TABLE image_zoo DROP FOREIGN KEY FK_C1A5EF66FFE875C9');
        $this->addSql('DROP TABLE habitats');
        $this->addSql('DROP TABLE image_zoo');
    }
}
