<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240908132028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194DFFE875C9');
        $this->addSql('DROP INDEX IDX_9ABE194DFFE875C9 ON animaux');
        $this->addSql('ALTER TABLE animaux DROP zoo_arcadia_id');
        $this->addSql('ALTER TABLE carousel DROP FOREIGN KEY FK_1DD74700FFE875C9');
        $this->addSql('DROP INDEX UNIQ_1DD74700FFE875C9 ON carousel');
        $this->addSql('ALTER TABLE carousel DROP zoo_arcadia_id');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169FFE875C9');
        $this->addSql('DROP INDEX IDX_7332E169FFE875C9 ON services');
        $this->addSql('ALTER TABLE services DROP zoo_arcadia_id');
        $this->addSql('ALTER TABLE zoo_arcadia DROP FOREIGN KEY FK_AF4DDFC5C1CE5B98');
        $this->addSql('DROP INDEX UNIQ_AF4DDFC5C1CE5B98 ON zoo_arcadia');
        $this->addSql('ALTER TABLE zoo_arcadia DROP carousel_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux ADD zoo_arcadia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194DFFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('CREATE INDEX IDX_9ABE194DFFE875C9 ON animaux (zoo_arcadia_id)');
        $this->addSql('ALTER TABLE carousel ADD zoo_arcadia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE carousel ADD CONSTRAINT FK_1DD74700FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DD74700FFE875C9 ON carousel (zoo_arcadia_id)');
        $this->addSql('ALTER TABLE services ADD zoo_arcadia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169FFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('CREATE INDEX IDX_7332E169FFE875C9 ON services (zoo_arcadia_id)');
        $this->addSql('ALTER TABLE zoo_arcadia ADD carousel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE zoo_arcadia ADD CONSTRAINT FK_AF4DDFC5C1CE5B98 FOREIGN KEY (carousel_id) REFERENCES carousel (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF4DDFC5C1CE5B98 ON zoo_arcadia (carousel_id)');
    }
}
