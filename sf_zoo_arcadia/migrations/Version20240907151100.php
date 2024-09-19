<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240907151100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F3FFE875C9');
        $this->addSql('DROP INDEX IDX_B5E492F3FFE875C9 ON habitats');
        $this->addSql('ALTER TABLE habitats DROP zoo_arcadia_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitats ADD zoo_arcadia_id INT NOT NULL');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F3FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('CREATE INDEX IDX_B5E492F3FFE875C9 ON habitats (zoo_arcadia_id)');
    }
}
