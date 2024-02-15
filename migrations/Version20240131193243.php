<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240131193243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE responsable ADD fidel_id INT DEFAULT NULL, ADD departement_id INT DEFAULT NULL, ADD sousdepartement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D0747CF9E8B FOREIGN KEY (fidel_id) REFERENCES fidel (id)');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D075ECEA5BF FOREIGN KEY (sousdepartement_id) REFERENCES sous_departement (id)');
        $this->addSql('CREATE INDEX IDX_52520D0747CF9E8B ON responsable (fidel_id)');
        $this->addSql('CREATE INDEX IDX_52520D07CCF9E01E ON responsable (departement_id)');
        $this->addSql('CREATE INDEX IDX_52520D075ECEA5BF ON responsable (sousdepartement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D0747CF9E8B');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D07CCF9E01E');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D075ECEA5BF');
        $this->addSql('DROP INDEX IDX_52520D0747CF9E8B ON responsable');
        $this->addSql('DROP INDEX IDX_52520D07CCF9E01E ON responsable');
        $this->addSql('DROP INDEX IDX_52520D075ECEA5BF ON responsable');
        $this->addSql('ALTER TABLE responsable DROP fidel_id, DROP departement_id, DROP sousdepartement_id');
    }
}
