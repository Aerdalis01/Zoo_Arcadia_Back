<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240718124153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_rendu_vet ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compte_rendu_vet ADD CONSTRAINT FK_96F75B8A642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_96F75B8A642B8210 ON compte_rendu_vet (admin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_rendu_vet DROP FOREIGN KEY FK_96F75B8A642B8210');
        $this->addSql('DROP INDEX IDX_96F75B8A642B8210 ON compte_rendu_vet');
        $this->addSql('ALTER TABLE compte_rendu_vet DROP admin_id');
    }
}
