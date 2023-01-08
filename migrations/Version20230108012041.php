<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108012041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_aide (id INT AUTO_INCREMENT NOT NULL, aides_id INT DEFAULT NULL, intitule VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_AEB803F64570D05B (aides_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_aide ADD CONSTRAINT FK_AEB803F64570D05B FOREIGN KEY (aides_id) REFERENCES aide (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_aide DROP FOREIGN KEY FK_AEB803F64570D05B');
        $this->addSql('DROP TABLE categorie_aide');
    }
}
