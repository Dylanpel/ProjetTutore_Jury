<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261123125210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX an_parcour_unique ON annee (an, id_parcour)');
        $this->addSql('ALTER TABLE annee_user DROP FOREIGN KEY `FK_1B4C4363543EC5F0`');
        $this->addSql('DROP INDEX IDX_1B4C4363543EC5F0 ON annee_user');
        // Renommage (et non suppression/recréation) pour conserver les données existantes
        $this->addSql('ALTER TABLE annee_user CHANGE annee_id id_annee INT NOT NULL');
        $this->addSql('ALTER TABLE annee_user ADD CONSTRAINT FK_1B4C4363301784FF FOREIGN KEY (id_annee) REFERENCES annee (id)');
        $this->addSql('CREATE UNIQUE INDEX user_annee_unique ON annee_user (id_user, id_annee)');
        $this->addSql('CREATE INDEX IDX_1B4C4363301784FF ON annee_user (id_annee)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB4C4D4E6C6E55B5 ON diplome (nom)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB4C4D4E81CFA4CE ON diplome (rang)');
        $this->addSql('CREATE UNIQUE INDEX etudiant_annee_unique ON note_annee (id_etudiant, id_annee)');
        $this->addSql('CREATE UNIQUE INDEX etudiant_division_unique ON note_division (id_etudiant, id_division)');
        $this->addSql('CREATE UNIQUE INDEX etudiant_groupe_unique ON note_groupe (etudiant_id, groupe_id)');
        $this->addSql('ALTER TABLE note_ue CHANGE remarque remarque LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX etudiant_ue_unique ON note_ue (etudiant_id, ue_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B7E5295681CFA4CE ON parcour (rang)');
        $this->addSql('CREATE UNIQUE INDEX nom_mention_unique ON parcour (nom, id_mention)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX an_parcour_unique ON annee');
        $this->addSql('ALTER TABLE annee_user DROP FOREIGN KEY FK_1B4C4363301784FF');
        $this->addSql('DROP INDEX user_annee_unique ON annee_user');
        $this->addSql('DROP INDEX IDX_1B4C4363301784FF ON annee_user');
        $this->addSql('ALTER TABLE annee_user CHANGE id_annee annee_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annee_user ADD CONSTRAINT `FK_1B4C4363543EC5F0` FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('CREATE INDEX IDX_1B4C4363543EC5F0 ON annee_user (annee_id)');
        $this->addSql('DROP INDEX UNIQ_EB4C4D4E6C6E55B5 ON diplome');
        $this->addSql('DROP INDEX UNIQ_EB4C4D4E81CFA4CE ON diplome');
        $this->addSql('DROP INDEX etudiant_annee_unique ON note_annee');
        $this->addSql('DROP INDEX etudiant_division_unique ON note_division');
        $this->addSql('DROP INDEX etudiant_groupe_unique ON note_groupe');
        $this->addSql('DROP INDEX etudiant_ue_unique ON note_ue');
        $this->addSql('ALTER TABLE note_ue CHANGE remarque remarque LONGTEXT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_B7E5295681CFA4CE ON parcour');
        $this->addSql('DROP INDEX nom_mention_unique ON parcour');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON `user`');
    }
}
