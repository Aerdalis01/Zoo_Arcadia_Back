<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240902103853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AB24FC0C');
        $this->addSql('ALTER TABLE images CHANGE sous_service_id sous_service_id INT NOT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AB24FC0C FOREIGN KEY (sous_service_id) REFERENCES sous_service (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AB24FC0C');
        $this->addSql('ALTER TABLE images CHANGE sous_service_id sous_service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AB24FC0C FOREIGN KEY (sous_service_id) REFERENCES sous_service (id)');
    }
}
