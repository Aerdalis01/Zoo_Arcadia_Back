<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240718103421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alimentation (id INT AUTO_INCREMENT NOT NULL, vétérinaire_id INT DEFAULT NULL, INDEX IDX_8E65DFA01186E1FE (vétérinaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alimentation ADD CONSTRAINT FK_8E65DFA01186E1FE FOREIGN KEY (vétérinaire_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alimentation DROP FOREIGN KEY FK_8E65DFA01186E1FE');
        $this->addSql('DROP TABLE alimentation');
    }
}
