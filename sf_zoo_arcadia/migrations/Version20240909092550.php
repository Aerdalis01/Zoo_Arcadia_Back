<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240909092550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194D642B8210');
        $this->addSql('DROP INDEX IDX_9ABE194D642B8210 ON animaux');
        $this->addSql('ALTER TABLE animaux DROP admin_id');
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F3642B8210');
        $this->addSql('DROP INDEX IDX_B5E492F3642B8210 ON habitats');
        $this->addSql('ALTER TABLE habitats DROP admin_id');
        $this->addSql('ALTER TABLE horaires DROP FOREIGN KEY FK_39B7118F642B8210');
        $this->addSql('DROP INDEX IDX_39B7118F642B8210 ON horaires');
        $this->addSql('ALTER TABLE horaires DROP admin_id');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169642B8210');
        $this->addSql('DROP INDEX IDX_7332E169642B8210 ON services');
        $this->addSql('ALTER TABLE services DROP admin_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194D642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9ABE194D642B8210 ON animaux (admin_id)');
        $this->addSql('ALTER TABLE habitats ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F3642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B5E492F3642B8210 ON habitats (admin_id)');
        $this->addSql('ALTER TABLE horaires ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE horaires ADD CONSTRAINT FK_39B7118F642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_39B7118F642B8210 ON horaires (admin_id)');
        $this->addSql('ALTER TABLE services ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7332E169642B8210 ON services (admin_id)');
    }
}
