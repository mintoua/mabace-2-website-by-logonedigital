<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230114003041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cycle (id INT AUTO_INCREMENT NOT NULL, calendrier_benef_id INT DEFAULT NULL, nom_clyle VARCHAR(60) NOT NULL, created_at DATETIME NOT NULL, date_deb DATETIME NOT NULL, date_fin DATETIME NOT NULL, etat TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_B086D1933B340161 (calendrier_benef_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cycle ADD CONSTRAINT FK_B086D1933B340161 FOREIGN KEY (calendrier_benef_id) REFERENCES calendrier_benef (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cycle DROP FOREIGN KEY FK_B086D1933B340161');
        $this->addSql('DROP TABLE cycle');
    }
}
