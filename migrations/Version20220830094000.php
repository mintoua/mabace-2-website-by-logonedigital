<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220830094000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D8C514352 FOREIGN KEY (category_post_id) REFERENCES category_post (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D8C514352 ON post (category_post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D8C514352');
        $this->addSql('DROP INDEX IDX_5A8A6C8D8C514352 ON post');
    }
}
