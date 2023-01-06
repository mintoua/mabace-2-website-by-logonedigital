<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221226183259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aide (id INT AUTO_INCREMENT NOT NULL, id_membre_id INT NOT NULL, type_aide VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_D99184A1EAAC4B6D (id_membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE beneficiere (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, calendrier_benef_id INT NOT NULL, INDEX IDX_69B7B0F96A99F74A (membre_id), INDEX IDX_69B7B0F93B340161 (calendrier_benef_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aide ADD CONSTRAINT FK_D99184A1EAAC4B6D FOREIGN KEY (id_membre_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE beneficiere ADD CONSTRAINT FK_69B7B0F96A99F74A FOREIGN KEY (membre_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE beneficiere ADD CONSTRAINT FK_69B7B0F93B340161 FOREIGN KEY (calendrier_benef_id) REFERENCES calendrier_benef (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aide DROP FOREIGN KEY FK_D99184A1EAAC4B6D');
        $this->addSql('ALTER TABLE beneficiere DROP FOREIGN KEY FK_69B7B0F96A99F74A');
        $this->addSql('ALTER TABLE beneficiere DROP FOREIGN KEY FK_69B7B0F93B340161');
        $this->addSql('DROP TABLE aide');
        $this->addSql('DROP TABLE beneficiere');
    }
}
