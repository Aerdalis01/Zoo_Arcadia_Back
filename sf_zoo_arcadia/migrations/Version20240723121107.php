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
        return 'Create ZooArcadia';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE zoo_arcadia (
            id INT AUTO_INCREMENT NOT NULL,
            nom VARCHAR(25) NOT NULL,
            adresse VARCHAR(75) NOT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            carousel_id INT DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        
        $this->addSql('DROP TABLE zoo_arcadia');

    }
}
