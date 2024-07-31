<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240731151833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaires ADD info_service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE horaires ADD CONSTRAINT FK_39B7118FB599954A FOREIGN KEY (info_service_id) REFERENCES services (id)');
        $this->addSql('CREATE INDEX IDX_39B7118FB599954A ON horaires (info_service_id)');
        $this->addSql('ALTER TABLE services ADD carte_zoo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169ECB8F4DE FOREIGN KEY (carte_zoo_id) REFERENCES images (id)');
        $this->addSql('CREATE INDEX IDX_7332E169ECB8F4DE ON services (carte_zoo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaires DROP FOREIGN KEY FK_39B7118FB599954A');
        $this->addSql('DROP INDEX IDX_39B7118FB599954A ON horaires');
        $this->addSql('ALTER TABLE horaires DROP info_service_id');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169ECB8F4DE');
        $this->addSql('DROP INDEX IDX_7332E169ECB8F4DE ON services');
        $this->addSql('ALTER TABLE services DROP carte_zoo_id');
    }
}
