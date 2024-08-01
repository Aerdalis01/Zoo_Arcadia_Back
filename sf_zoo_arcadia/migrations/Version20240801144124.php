<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801144124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires_habitat ADD veterinaire_id INT DEFAULT NULL, ADD habitat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaires_habitat ADD CONSTRAINT FK_D9ABEAFE5C80924 FOREIGN KEY (veterinaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaires_habitat ADD CONSTRAINT FK_D9ABEAFEAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
        $this->addSql('CREATE INDEX IDX_D9ABEAFE5C80924 ON commentaires_habitat (veterinaire_id)');
        $this->addSql('CREATE INDEX IDX_D9ABEAFEAFFE2D26 ON commentaires_habitat (habitat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires_habitat DROP FOREIGN KEY FK_D9ABEAFE5C80924');
        $this->addSql('ALTER TABLE commentaires_habitat DROP FOREIGN KEY FK_D9ABEAFEAFFE2D26');
        $this->addSql('DROP INDEX IDX_D9ABEAFE5C80924 ON commentaires_habitat');
        $this->addSql('DROP INDEX IDX_D9ABEAFEAFFE2D26 ON commentaires_habitat');
        $this->addSql('ALTER TABLE commentaires_habitat DROP veterinaire_id, DROP habitat_id');
    }
}
