<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221226185630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, type VARCHAR(50) NOT NULL, montant DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, ended_at DATETIME NOT NULL, taux_interet DOUBLE PRECISION NOT NULL, taux_interet_delai DOUBLE PRECISION NOT NULL, etat TINYINT(1) NOT NULL, INDEX IDX_364071D76A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remboursement (id INT AUTO_INCREMENT NOT NULL, emprunt_id INT DEFAULT NULL, refund_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C0C0D9EFAE7FEF94 (emprunt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sanction (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, type VARCHAR(100) NOT NULL, raison LONGTEXT NOT NULL, intitule VARCHAR(100) NOT NULL, INDEX IDX_6D6491AF6A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D76A99F74A FOREIGN KEY (membre_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE remboursement ADD CONSTRAINT FK_C0C0D9EFAE7FEF94 FOREIGN KEY (emprunt_id) REFERENCES emprunt (id)');
        $this->addSql('ALTER TABLE sanction ADD CONSTRAINT FK_6D6491AF6A99F74A FOREIGN KEY (membre_id) REFERENCES member (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D76A99F74A');
        $this->addSql('ALTER TABLE remboursement DROP FOREIGN KEY FK_C0C0D9EFAE7FEF94');
        $this->addSql('ALTER TABLE sanction DROP FOREIGN KEY FK_6D6491AF6A99F74A');
        $this->addSql('DROP TABLE emprunt');
        $this->addSql('DROP TABLE remboursement');
        $this->addSql('DROP TABLE sanction');
    }
}
