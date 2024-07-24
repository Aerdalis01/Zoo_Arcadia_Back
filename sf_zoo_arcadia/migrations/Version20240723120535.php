<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723120535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carousel_slide ADD carousel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE carousel_slide ADD CONSTRAINT FK_BD7937A4C1CE5B98 FOREIGN KEY (carousel_id) REFERENCES carousel (id)');
        $this->addSql('CREATE INDEX IDX_BD7937A4C1CE5B98 ON carousel_slide (carousel_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carousel_slide DROP FOREIGN KEY FK_BD7937A4C1CE5B98');
        $this->addSql('DROP INDEX IDX_BD7937A4C1CE5B98 ON carousel_slide');
        $this->addSql('ALTER TABLE carousel_slide DROP carousel_id');
    }
}
