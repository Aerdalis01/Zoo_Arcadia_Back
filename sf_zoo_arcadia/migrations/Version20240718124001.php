<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240718124001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services ADD employe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E1691B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7332E1691B65292 ON services (employe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E1691B65292');
        $this->addSql('DROP INDEX IDX_7332E1691B65292 ON services');
        $this->addSql('ALTER TABLE services DROP employe_id');
    }
}
