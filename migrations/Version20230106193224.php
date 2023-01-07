<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230106193224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beneficiere DROP FOREIGN KEY FK_69B7B0F96A99F74A');
        $this->addSql('DROP INDEX IDX_69B7B0F96A99F74A ON beneficiere');
        $this->addSql('ALTER TABLE beneficiere CHANGE membre_id membres_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE beneficiere ADD CONSTRAINT FK_69B7B0F971128C5C FOREIGN KEY (membres_id) REFERENCES member (id)');
        $this->addSql('CREATE INDEX IDX_69B7B0F971128C5C ON beneficiere (membres_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beneficiere DROP FOREIGN KEY FK_69B7B0F971128C5C');
        $this->addSql('DROP INDEX IDX_69B7B0F971128C5C ON beneficiere');
        $this->addSql('ALTER TABLE beneficiere CHANGE membres_id membre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE beneficiere ADD CONSTRAINT FK_69B7B0F96A99F74A FOREIGN KEY (membre_id) REFERENCES member (id)');
        $this->addSql('CREATE INDEX IDX_69B7B0F96A99F74A ON beneficiere (membre_id)');
    }
}
