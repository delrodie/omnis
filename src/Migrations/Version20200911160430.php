<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200911160430 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE scolarite (id INT AUTO_INCREMENT NOT NULL, classe_id INT DEFAULT NULL, filiere_id INT DEFAULT NULL, annee_id INT DEFAULT NULL, montant INT DEFAULT NULL, INDEX IDX_276250AB8F5EA509 (classe_id), INDEX IDX_276250AB180AA129 (filiere_id), INDEX IDX_276250AB543EC5F0 (annee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scolarite ADD CONSTRAINT FK_276250AB8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE scolarite ADD CONSTRAINT FK_276250AB180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE scolarite ADD CONSTRAINT FK_276250AB543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE scolarite');
    }
}
