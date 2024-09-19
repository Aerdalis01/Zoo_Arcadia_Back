<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240907145238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitats ADD image_id INT NOT NULL');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F33DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B5E492F33DA5256D ON habitats (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F33DA5256D');
        $this->addSql('DROP INDEX UNIQ_B5E492F33DA5256D ON habitats');
        $this->addSql('ALTER TABLE habitats DROP image_id');
    }
}
