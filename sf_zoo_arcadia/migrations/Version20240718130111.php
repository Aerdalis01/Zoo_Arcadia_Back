<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240718130111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F642B8210 ON animal (admin_id)');
        $this->addSql('ALTER TABLE habitats ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F3642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B5E492F3642B8210 ON habitats (admin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F642B8210');
        $this->addSql('DROP INDEX IDX_6AAB231F642B8210 ON animal');
        $this->addSql('ALTER TABLE animal DROP admin_id');
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F3642B8210');
        $this->addSql('DROP INDEX IDX_B5E492F3642B8210 ON habitats');
        $this->addSql('ALTER TABLE habitats DROP admin_id');
    }
}
