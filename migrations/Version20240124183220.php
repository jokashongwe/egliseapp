<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240124183220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE responsable (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD fidel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64947CF9E8B FOREIGN KEY (fidel_id) REFERENCES fidel (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64947CF9E8B ON user (fidel_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE responsable');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64947CF9E8B');
        $this->addSql('DROP INDEX IDX_8D93D64947CF9E8B ON `user`');
        $this->addSql('ALTER TABLE `user` DROP fidel_id');
    }
}
