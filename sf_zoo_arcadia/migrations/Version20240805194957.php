<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240805194957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alimentation DROP FOREIGN KEY FK_8E65DFA01186E1FE');
        $this->addSql('ALTER TABLE alimentation DROP FOREIGN KEY FK_8E65DFA01B65292');
        $this->addSql('ALTER TABLE alimentation DROP FOREIGN KEY FK_8E65DFA0F075B8D0');
        $this->addSql('DROP TABLE alimentation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alimentation (id INT AUTO_INCREMENT NOT NULL, vétérinaire_id INT DEFAULT NULL, compte_rendu_vet_id INT DEFAULT NULL, employe_id INT DEFAULT NULL, date DATE NOT NULL, time TIME NOT NULL, nourriture VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, quantite DOUBLE PRECISION NOT NULL, INDEX IDX_8E65DFA0F075B8D0 (compte_rendu_vet_id), INDEX IDX_8E65DFA01B65292 (employe_id), INDEX IDX_8E65DFA01186E1FE (vétérinaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE alimentation ADD CONSTRAINT FK_8E65DFA01186E1FE FOREIGN KEY (vétérinaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE alimentation ADD CONSTRAINT FK_8E65DFA01B65292 FOREIGN KEY (employe_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE alimentation ADD CONSTRAINT FK_8E65DFA0F075B8D0 FOREIGN KEY (compte_rendu_vet_id) REFERENCES compte_rendu_vet (id)');
    }
}
