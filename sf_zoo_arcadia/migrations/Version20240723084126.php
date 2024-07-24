<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723084126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F35D3C6F5');
        $this->addSql('ALTER TABLE horaire CHANGE heure_ouverture heure_ouverture JSON NOT NULL COMMENT \'(DC2Type:json)\', CHANGE heure_fermeture heure_fermeture JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE horaire CHANGE heure_ouverture heure_ouverture LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE heure_fermeture heure_fermeture LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }
}
