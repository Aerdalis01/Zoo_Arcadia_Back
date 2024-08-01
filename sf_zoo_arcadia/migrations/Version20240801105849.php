<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801105849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux ADD race_id INT DEFAULT NULL, ADD admin_id INT DEFAULT NULL, ADD zoo_arcadia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194D6E59D40D FOREIGN KEY (race_id) REFERENCES races (id)');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194D642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194DFFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('CREATE INDEX IDX_9ABE194D6E59D40D ON animaux (race_id)');
        $this->addSql('CREATE INDEX IDX_9ABE194D642B8210 ON animaux (admin_id)');
        $this->addSql('CREATE INDEX IDX_9ABE194DFFE875C9 ON animaux (zoo_arcadia_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194D6E59D40D');
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194D642B8210');
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194DFFE875C9');
        $this->addSql('DROP INDEX IDX_9ABE194D6E59D40D ON animaux');
        $this->addSql('DROP INDEX IDX_9ABE194D642B8210 ON animaux');
        $this->addSql('DROP INDEX IDX_9ABE194DFFE875C9 ON animaux');
        $this->addSql('ALTER TABLE animaux DROP race_id, DROP admin_id, DROP zoo_arcadia_id');
    }
}
