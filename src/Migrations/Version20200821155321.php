<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821155321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, filiere_id INT DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, date_naissance VARCHAR(255) DEFAULT NULL, lieu_naissance VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, correspondant VARCHAR(255) DEFAULT NULL, niveau_etude VARCHAR(255) DEFAULT NULL, dernier_diplome VARCHAR(255) DEFAULT NULL, baccalaureat VARCHAR(255) DEFAULT NULL, file_identite VARCHAR(255) DEFAULT NULL, file_diplome VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, annee VARCHAR(255) DEFAULT NULL, INDEX IDX_5E90F6D6180AA129 (filiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE inscription');
    }
}
