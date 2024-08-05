<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240722132250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Habitats table with relationships';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE habitats (
            id INT AUTO_INCREMENT NOT NULL,
            zoo_arcadia_id INT NOT NULL,
            admin_id INT DEFAULT NULL,
            nom VARCHAR(25) NOT NULL,
            description LONGTEXT NOT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE habitats');
    }
}
