<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241002091511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services DROP INDEX IDX_7332E169ECB8F4DE, ADD UNIQUE INDEX UNIQ_7332E169ECB8F4DE (carte_zoo_id)');
        $this->addSql('ALTER TABLE services ADD type_service VARCHAR(25) NOT NULL, DROP Type_Services');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services DROP INDEX UNIQ_7332E169ECB8F4DE, ADD INDEX IDX_7332E169ECB8F4DE (carte_zoo_id)');
        $this->addSql('ALTER TABLE services ADD Type_Services VARCHAR(255) NOT NULL, DROP type_service');
    }
}
