<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240731154557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sous_service (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, nom_sous_service VARCHAR(25) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_C294E29FED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sous_service ADD CONSTRAINT FK_C294E29FED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE images ADD sous_service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AB24FC0C FOREIGN KEY (sous_service_id) REFERENCES sous_service (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AB24FC0C ON images (sous_service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AB24FC0C');
        $this->addSql('ALTER TABLE sous_service DROP FOREIGN KEY FK_C294E29FED5CA9E6');
        $this->addSql('DROP TABLE sous_service');
        $this->addSql('DROP INDEX IDX_E01FBE6AB24FC0C ON images');
        $this->addSql('ALTER TABLE images DROP sous_service_id');
    }
}