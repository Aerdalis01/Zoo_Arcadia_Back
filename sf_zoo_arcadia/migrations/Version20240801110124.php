<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801110124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194D3DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9ABE194D3DA5256D ON animaux (image_id)');
        $this->addSql('ALTER TABLE compte_rendu_vet ADD animaux_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compte_rendu_vet ADD CONSTRAINT FK_96F75B8AA9DAECAA FOREIGN KEY (animaux_id) REFERENCES animaux (id)');
        $this->addSql('CREATE INDEX IDX_96F75B8AA9DAECAA ON compte_rendu_vet (animaux_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194D3DA5256D');
        $this->addSql('DROP INDEX UNIQ_9ABE194D3DA5256D ON animaux');
        $this->addSql('ALTER TABLE animaux DROP image_id');
        $this->addSql('ALTER TABLE compte_rendu_vet DROP FOREIGN KEY FK_96F75B8AA9DAECAA');
        $this->addSql('DROP INDEX IDX_96F75B8AA9DAECAA ON compte_rendu_vet');
        $this->addSql('ALTER TABLE compte_rendu_vet DROP animaux_id');
    }
}
