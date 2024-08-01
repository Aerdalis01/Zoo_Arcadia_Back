<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801101433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport_alimentation ADD animal_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE rapport_alimentation ADD CONSTRAINT FK_2A93B0338E962C16 FOREIGN KEY (animal_id) REFERENCES animaux (id)');
        $this->addSql('CREATE INDEX IDX_2A93B0338E962C16 ON rapport_alimentation (animal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport_alimentation DROP FOREIGN KEY FK_2A93B0338E962C16');
        $this->addSql('DROP INDEX IDX_2A93B0338E962C16 ON rapport_alimentation');
        $this->addSql('ALTER TABLE rapport_alimentation DROP animal_id, DROP created_at, DROP updated_at');
    }
}
