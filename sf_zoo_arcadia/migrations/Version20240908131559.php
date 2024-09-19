<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240908131559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0FFE875C9');
        $this->addSql('DROP INDEX IDX_8F91ABF0FFE875C9 ON avis');
        $this->addSql('ALTER TABLE avis DROP zoo_arcadia_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis ADD zoo_arcadia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0FFE875C9 ON avis (zoo_arcadia_id)');
    }
}
