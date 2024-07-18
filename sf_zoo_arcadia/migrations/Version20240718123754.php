<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240718123754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, employe_id INT DEFAULT NULL, email VARCHAR(64) NOT NULL, titre VARCHAR(25) NOT NULL, commentaire VARCHAR(255) NOT NULL, INDEX IDX_4C62E6381B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6381B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE alimentation CHANGE heure time TIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6381B65292');
        $this->addSql('DROP TABLE contact');
        $this->addSql('ALTER TABLE alimentation CHANGE time heure TIME NOT NULL');
    }
}
