<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240718123403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alimentation ADD employe_id INT DEFAULT NULL, ADD date DATE NOT NULL, ADD time TIME NOT NULL, ADD nourriture VARCHAR(255) NOT NULL, ADD quantite DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE alimentation ADD CONSTRAINT FK_8E65DFA01B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8E65DFA01B65292 ON alimentation (employe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alimentation DROP FOREIGN KEY FK_8E65DFA01B65292');
        $this->addSql('DROP INDEX IDX_8E65DFA01B65292 ON alimentation');
        $this->addSql('ALTER TABLE alimentation DROP employe_id, DROP date, DROP time, DROP nourriture, DROP quantite');
    }
}
