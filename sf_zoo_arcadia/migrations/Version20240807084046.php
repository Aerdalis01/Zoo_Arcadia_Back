<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240807084046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaires ADD heure_ouverture_zoo TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', ADD heure_fermeture_zoo TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', ADD horaires_services JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', DROP heure_ouverture, DROP heure_fermeture');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaires ADD heure_ouverture JSON NOT NULL COMMENT \'(DC2Type:json)\', ADD heure_fermeture JSON NOT NULL COMMENT \'(DC2Type:json)\', DROP heure_ouverture_zoo, DROP heure_fermeture_zoo, DROP horaires_services');
    }
}
