<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240731112616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, zoo_arcadia_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, habitats_id INT DEFAULT NULL, prenom VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6AAB231F35D3C6F5 (habitats_id), INDEX IDX_6AAB231F642B8210 (admin_id), INDEX IDX_6AAB231FFFE875C9 (zoo_arcadia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE consultation_animal (consultation_id INT NOT NULL, animal_id INT NOT NULL, INDEX IDX_B606B43262FF6CDF (consultation_id), INDEX IDX_B606B4328E962C16 (animal_id), PRIMARY KEY(consultation_id, animal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FFFE875C9 FOREIGN KEY (zoo_arcadia_id) REFERENCES zoo_arcadia (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consultation_animal ADD CONSTRAINT FK_B606B4328E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consultation_animal ADD CONSTRAINT FK_B606B43262FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE animaux');
        $this->addSql('ALTER TABLE rapport_alimentation ADD animal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_alimentation ADD CONSTRAINT FK_2A93B0338E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('CREATE INDEX IDX_2A93B0338E962C16 ON rapport_alimentation (animal_id)');
    }
}
