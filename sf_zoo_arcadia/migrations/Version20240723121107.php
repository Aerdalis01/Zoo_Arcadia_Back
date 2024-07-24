<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723121107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zoo_arcadia ADD carousel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE zoo_arcadia ADD CONSTRAINT FK_AF4DDFC5C1CE5B98 FOREIGN KEY (carousel_id) REFERENCES carousel (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF4DDFC5C1CE5B98 ON zoo_arcadia (carousel_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zoo_arcadia DROP FOREIGN KEY FK_AF4DDFC5C1CE5B98');
        $this->addSql('DROP INDEX UNIQ_AF4DDFC5C1CE5B98 ON zoo_arcadia');
        $this->addSql('ALTER TABLE zoo_arcadia DROP carousel_id');
    }
}
