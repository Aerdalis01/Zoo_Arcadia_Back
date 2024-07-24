<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724104445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carousel ADD zoo_arcadia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE carousel ADD CONSTRAINT FK_1DD74700FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DD74700FFE875C9 ON carousel (zoo_arcadia_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carousel DROP FOREIGN KEY FK_1DD74700FFE875C9');
        $this->addSql('DROP INDEX UNIQ_1DD74700FFE875C9 ON carousel');
        $this->addSql('ALTER TABLE carousel DROP zoo_arcadia_id');
    }
}
