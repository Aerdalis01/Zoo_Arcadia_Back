<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801143722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_rendu_vet DROP FOREIGN KEY FK_96F75B8A642B8210');
        $this->addSql('ALTER TABLE compte_rendu_vet DROP FOREIGN KEY FK_96F75B8A1186E1FE');
        $this->addSql('DROP INDEX IDX_96F75B8A642B8210 ON compte_rendu_vet');
        $this->addSql('DROP INDEX IDX_96F75B8A1186E1FE ON compte_rendu_vet');
        $this->addSql('ALTER TABLE compte_rendu_vet ADD veterinaire_id INT DEFAULT NULL, DROP vétérinaire_id, DROP admin_id');
        $this->addSql('ALTER TABLE compte_rendu_vet ADD CONSTRAINT FK_96F75B8A5C80924 FOREIGN KEY (veterinaire_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_96F75B8A5C80924 ON compte_rendu_vet (veterinaire_id)');
        $this->addSql('ALTER TABLE horaires ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE horaires ADD CONSTRAINT FK_39B7118F642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_39B7118F642B8210 ON horaires (admin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_rendu_vet DROP FOREIGN KEY FK_96F75B8A5C80924');
        $this->addSql('DROP INDEX IDX_96F75B8A5C80924 ON compte_rendu_vet');
        $this->addSql('ALTER TABLE compte_rendu_vet ADD admin_id INT DEFAULT NULL, CHANGE veterinaire_id vétérinaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compte_rendu_vet ADD CONSTRAINT FK_96F75B8A642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE compte_rendu_vet ADD CONSTRAINT FK_96F75B8A1186E1FE FOREIGN KEY (vétérinaire_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_96F75B8A642B8210 ON compte_rendu_vet (admin_id)');
        $this->addSql('CREATE INDEX IDX_96F75B8A1186E1FE ON compte_rendu_vet (vétérinaire_id)');
        $this->addSql('ALTER TABLE horaires DROP FOREIGN KEY FK_39B7118F642B8210');
        $this->addSql('DROP INDEX IDX_39B7118F642B8210 ON horaires');
        $this->addSql('ALTER TABLE horaires DROP admin_id');
    }
}
