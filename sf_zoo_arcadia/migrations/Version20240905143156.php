<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240905143156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194D35D3C6F5');
        $this->addSql('DROP INDEX IDX_9ABE194D35D3C6F5 ON animaux');
        $this->addSql('ALTER TABLE animaux CHANGE habitats_id habitat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194DAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
        $this->addSql('CREATE INDEX IDX_9ABE194DAFFE2D26 ON animaux (habitat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194DAFFE2D26');
        $this->addSql('DROP INDEX IDX_9ABE194DAFFE2D26 ON animaux');
        $this->addSql('ALTER TABLE animaux CHANGE habitat_id habitats_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194D35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('CREATE INDEX IDX_9ABE194D35D3C6F5 ON animaux (habitats_id)');
    }
}
