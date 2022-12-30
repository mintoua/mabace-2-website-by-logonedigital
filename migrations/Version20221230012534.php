<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221230012534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aide DROP FOREIGN KEY FK_D99184A1EAAC4B6D');
        $this->addSql('DROP INDEX IDX_D99184A1EAAC4B6D ON aide');
        $this->addSql('ALTER TABLE aide ADD id_membre LONGTEXT NOT NULL, DROP id_membre_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aide ADD id_membre_id INT NOT NULL, DROP id_membre');
        $this->addSql('ALTER TABLE aide ADD CONSTRAINT FK_D99184A1EAAC4B6D FOREIGN KEY (id_membre_id) REFERENCES `member` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D99184A1EAAC4B6D ON aide (id_membre_id)');
    }
}
