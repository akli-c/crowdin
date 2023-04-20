<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230418203435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sources (id INT AUTO_INCREMENT NOT NULL, id_project_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, langue_origin VARCHAR(255) NOT NULL, langue_traduction VARCHAR(255) NOT NULL, traduction LONGTEXT DEFAULT NULL, INDEX IDX_D25D65F2B3E79F4B (id_project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sources ADD CONSTRAINT FK_D25D65F2B3E79F4B FOREIGN KEY (id_project_id) REFERENCES projects (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sources DROP FOREIGN KEY FK_D25D65F2B3E79F4B');
        $this->addSql('DROP TABLE sources');
    }
}
