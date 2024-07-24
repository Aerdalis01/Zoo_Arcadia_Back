<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723102643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zoo_arcadia DROP FOREIGN KEY FK_AF4DDFC5E181016');
        $this->addSql('DROP TABLE image_carousel');
        $this->addSql('DROP INDEX UNIQ_AF4DDFC5E181016 ON zoo_arcadia');
        $this->addSql('ALTER TABLE zoo_arcadia DROP image_carousel_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image_carousel (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image_path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image_sub_directory VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE zoo_arcadia ADD image_carousel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE zoo_arcadia ADD CONSTRAINT FK_AF4DDFC5E181016 FOREIGN KEY (image_carousel_id) REFERENCES image_carousel (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF4DDFC5E181016 ON zoo_arcadia (image_carousel_id)');
    }
}
