<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108224018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement ADD supprimer TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE fidel ADD departement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fidel ADD CONSTRAINT FK_852E1C14CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_852E1C14CCF9E01E ON fidel (departement_id)');
        $this->addSql('ALTER TABLE sous_departement ADD supprimer TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement DROP supprimer');
        $this->addSql('ALTER TABLE fidel DROP FOREIGN KEY FK_852E1C14CCF9E01E');
        $this->addSql('DROP INDEX IDX_852E1C14CCF9E01E ON fidel');
        $this->addSql('ALTER TABLE fidel DROP departement_id');
        $this->addSql('ALTER TABLE sous_departement DROP supprimer');
    }
}
