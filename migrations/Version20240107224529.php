<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240107224529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fidel ADD CONSTRAINT FK_852E1C145ECEA5BF FOREIGN KEY (sousdepartement_id) REFERENCES sous_departement (id)');
        $this->addSql('CREATE INDEX IDX_852E1C145ECEA5BF ON fidel (sousdepartement_id)');
        $this->addSql('ALTER TABLE sous_departement ADD departement_id INT NOT NULL, ADD responsable VARCHAR(255) DEFAULT NULL, ADD adjoint VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sous_departement ADD CONSTRAINT FK_814F2850CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_814F2850CCF9E01E ON sous_departement (departement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fidel DROP FOREIGN KEY FK_852E1C145ECEA5BF');
        $this->addSql('DROP INDEX IDX_852E1C145ECEA5BF ON fidel');
        $this->addSql('ALTER TABLE sous_departement DROP FOREIGN KEY FK_814F2850CCF9E01E');
        $this->addSql('DROP INDEX IDX_814F2850CCF9E01E ON sous_departement');
        $this->addSql('ALTER TABLE sous_departement DROP departement_id, DROP responsable, DROP adjoint');
    }
}
