<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221222201939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendrier_benef (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, date_benef DATETIME NOT NULL, INDEX IDX_9E2DE8D26A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tontine (id INT AUTO_INCREMENT NOT NULL, calendrier_benef_id INT DEFAULT NULL, type_tontine VARCHAR(150) NOT NULL, montant VARCHAR(100) NOT NULL, obligatoire TINYINT(1) DEFAULT NULL, INDEX IDX_3F164B7F3B340161 (calendrier_benef_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calendrier_benef ADD CONSTRAINT FK_9E2DE8D26A99F74A FOREIGN KEY (membre_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE tontine ADD CONSTRAINT FK_3F164B7F3B340161 FOREIGN KEY (calendrier_benef_id) REFERENCES calendrier_benef (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendrier_benef DROP FOREIGN KEY FK_9E2DE8D26A99F74A');
        $this->addSql('ALTER TABLE tontine DROP FOREIGN KEY FK_3F164B7F3B340161');
        $this->addSql('DROP TABLE calendrier_benef');
        $this->addSql('DROP TABLE tontine');
    }
}
