<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801105556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux ADD habitats_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194D35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('CREATE INDEX IDX_9ABE194D35D3C6F5 ON animaux (habitats_id)');
        $this->addSql('ALTER TABLE habitats ADD update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP image');
        $this->addSql('ALTER TABLE images ADD habitats_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A35D3C6F5 ON images (habitats_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194D35D3C6F5');
        $this->addSql('DROP INDEX IDX_9ABE194D35D3C6F5 ON animaux');
        $this->addSql('ALTER TABLE animaux DROP habitats_id');
        $this->addSql('ALTER TABLE habitats ADD image JSON NOT NULL COMMENT \'(DC2Type:json)\', DROP update_at');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A35D3C6F5');
        $this->addSql('DROP INDEX IDX_E01FBE6A35D3C6F5 ON images');
        $this->addSql('ALTER TABLE images DROP habitats_id');
    }
}
