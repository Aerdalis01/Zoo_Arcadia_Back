<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801144416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport_alimentation DROP FOREIGN KEY FK_2A93B033F075B8D0');
        $this->addSql('DROP INDEX IDX_2A93B033F075B8D0 ON rapport_alimentation');
        $this->addSql('ALTER TABLE rapport_alimentation DROP compte_rendu_vet_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport_alimentation ADD compte_rendu_vet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_alimentation ADD CONSTRAINT FK_2A93B033F075B8D0 FOREIGN KEY (compte_rendu_vet_id) REFERENCES compte_rendu_vet (id)');
        $this->addSql('CREATE INDEX IDX_2A93B033F075B8D0 ON rapport_alimentation (compte_rendu_vet_id)');
    }
}
