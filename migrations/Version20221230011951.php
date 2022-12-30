<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221230011951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendrier_benef DROP FOREIGN KEY FK_9E2DE8D26A99F74B');
        $this->addSql('ALTER TABLE calendrier_benef ADD tontine_id INT NOT NULL');
        $this->addSql('ALTER TABLE calendrier_benef ADD CONSTRAINT FK_9E2DE8D2DEB5C9FD FOREIGN KEY (tontine_id) REFERENCES tontine (id)');
        $this->addSql('CREATE INDEX IDX_9E2DE8D2DEB5C9FD ON calendrier_benef (tontine_id)');
        $this->addSql('ALTER TABLE tontine DROP FOREIGN KEY FK_3F164B7F3B340161');
        $this->addSql('DROP INDEX IDX_3F164B7F3B340161 ON tontine');
        $this->addSql('ALTER TABLE tontine ADD description LONGTEXT DEFAULT NULL, ADD intitule_tontine VARCHAR(100) NOT NULL, DROP calendrier_benef_id, CHANGE montant montant INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendrier_benef DROP FOREIGN KEY FK_9E2DE8D2DEB5C9FD');
        $this->addSql('DROP INDEX IDX_9E2DE8D2DEB5C9FD ON calendrier_benef');
        $this->addSql('ALTER TABLE calendrier_benef DROP tontine_id');
        $this->addSql('ALTER TABLE tontine ADD calendrier_benef_id INT DEFAULT NULL, DROP description, DROP intitule_tontine, CHANGE montant montant VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE tontine ADD CONSTRAINT FK_3F164B7F3B340161 FOREIGN KEY (calendrier_benef_id) REFERENCES calendrier_benef (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3F164B7F3B340161 ON tontine (calendrier_benef_id)');
    }
}
