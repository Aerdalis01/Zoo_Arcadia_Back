<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240906123859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux CHANGE habitat_id habitats_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194D35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('CREATE INDEX IDX_9ABE194D35D3C6F5 ON animaux (habitats_id)');
        $this->addSql('ALTER TABLE carousel ADD datetime VARCHAR(255) NOT NULL, ADD createdat VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194D35D3C6F5');
        $this->addSql('DROP INDEX IDX_9ABE194D35D3C6F5 ON animaux');
        $this->addSql('ALTER TABLE animaux CHANGE habitats_id habitat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE carousel DROP datetime, DROP createdat, DROP created_at');
    }
}
