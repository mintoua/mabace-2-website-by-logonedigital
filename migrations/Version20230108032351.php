<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108032351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aide_member (aide_id INT NOT NULL, member_id INT NOT NULL, INDEX IDX_5A106B5C661C0C23 (aide_id), INDEX IDX_5A106B5C7597D3FE (member_id), PRIMARY KEY(aide_id, member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aide_member ADD CONSTRAINT FK_5A106B5C661C0C23 FOREIGN KEY (aide_id) REFERENCES aide (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aide_member ADD CONSTRAINT FK_5A106B5C7597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aide DROP FOREIGN KEY FK_D99184A1EAAC4B6D');
        $this->addSql('DROP INDEX IDX_D99184A1EAAC4B6D ON aide');
        $this->addSql('ALTER TABLE aide ADD intitule VARCHAR(100) NOT NULL, DROP type_aide, DROP created_at, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE id_membre_id categorie_aides_id INT NOT NULL');
        $this->addSql('ALTER TABLE aide ADD CONSTRAINT FK_D99184A17DF79131 FOREIGN KEY (categorie_aides_id) REFERENCES categorie_aide (id)');
        $this->addSql('CREATE INDEX IDX_D99184A17DF79131 ON aide (categorie_aides_id)');
        $this->addSql('ALTER TABLE categorie_aide DROP FOREIGN KEY FK_AEB803F64570D05B');
        $this->addSql('DROP INDEX IDX_AEB803F64570D05B ON categorie_aide');
        $this->addSql('ALTER TABLE categorie_aide DROP aides_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aide_member DROP FOREIGN KEY FK_5A106B5C661C0C23');
        $this->addSql('ALTER TABLE aide_member DROP FOREIGN KEY FK_5A106B5C7597D3FE');
        $this->addSql('DROP TABLE aide_member');
        $this->addSql('ALTER TABLE aide DROP FOREIGN KEY FK_D99184A17DF79131');
        $this->addSql('DROP INDEX IDX_D99184A17DF79131 ON aide');
        $this->addSql('ALTER TABLE aide ADD type_aide VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL, DROP intitule, CHANGE description description LONGTEXT NOT NULL, CHANGE categorie_aides_id id_membre_id INT NOT NULL');
        $this->addSql('ALTER TABLE aide ADD CONSTRAINT FK_D99184A1EAAC4B6D FOREIGN KEY (id_membre_id) REFERENCES member (id)');
        $this->addSql('CREATE INDEX IDX_D99184A1EAAC4B6D ON aide (id_membre_id)');
        $this->addSql('ALTER TABLE categorie_aide ADD aides_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie_aide ADD CONSTRAINT FK_AEB803F64570D05B FOREIGN KEY (aides_id) REFERENCES aide (id)');
        $this->addSql('CREATE INDEX IDX_AEB803F64570D05B ON categorie_aide (aides_id)');
    }
}
