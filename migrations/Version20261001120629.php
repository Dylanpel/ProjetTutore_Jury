<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261001120629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note_annee CHANGE neutralis_note_mini neutralise_note_mini TINYINT NOT NULL');
        $this->addSql('ALTER TABLE note_groupe CHANGE neutralis_note_mini neutralise_note_mini TINYINT NOT NULL');
        $this->addSql('ALTER TABLE note_ue CHANGE neutralis_note_mini neutralise_note_mini TINYINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note_annee CHANGE neutralise_note_mini neutralis_note_mini TINYINT NOT NULL');
        $this->addSql('ALTER TABLE note_groupe CHANGE neutralise_note_mini neutralis_note_mini TINYINT NOT NULL');
        $this->addSql('ALTER TABLE note_ue CHANGE neutralise_note_mini neutralis_note_mini TINYINT NOT NULL');
    }
}
