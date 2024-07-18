<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240718095228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rapport_alimentation (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, employe_id INT DEFAULT NULL, date DATE NOT NULL, heure TIME NOT NULL, nourriture VARCHAR(255) NOT NULL, quantite DOUBLE PRECISION NOT NULL, INDEX IDX_2A93B0338E962C16 (animal_id), INDEX IDX_2A93B0331B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rapport_alimentation ADD CONSTRAINT FK_2A93B0338E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE rapport_alimentation ADD CONSTRAINT FK_2A93B0331B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport_alimentation DROP FOREIGN KEY FK_2A93B0338E962C16');
        $this->addSql('ALTER TABLE rapport_alimentation DROP FOREIGN KEY FK_2A93B0331B65292');
        $this->addSql('DROP TABLE rapport_alimentation');
    }
}
