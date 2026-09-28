<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260924125811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annee DROP FOREIGN KEY `FK_DE92C5CF9A561E99`');
        $this->addSql('DROP INDEX IDX_DE92C5CF9A561E99 ON annee');
        $this->addSql('ALTER TABLE annee CHANGE parcour_id id_parcour INT NOT NULL');
        $this->addSql('ALTER TABLE annee ADD CONSTRAINT FK_DE92C5CF69788026 FOREIGN KEY (id_parcour) REFERENCES parcour (id)');
        $this->addSql('CREATE INDEX IDX_DE92C5CF69788026 ON annee (id_parcour)');
        $this->addSql('ALTER TABLE annee_user DROP FOREIGN KEY `FK_1B4C4363FB88E14F`');
        $this->addSql('DROP INDEX IDX_1B4C4363FB88E14F ON annee_user');
        $this->addSql('ALTER TABLE annee_user CHANGE utilisateur_id id_user INT NOT NULL');
        $this->addSql('ALTER TABLE annee_user ADD CONSTRAINT FK_1B4C43636B3CA4B FOREIGN KEY (id_user) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_1B4C43636B3CA4B ON annee_user (id_user)');
        $this->addSql('ALTER TABLE epreuve DROP FOREIGN KEY `FK_D6ADE47F3BCB2E4B`');
        $this->addSql('ALTER TABLE epreuve DROP FOREIGN KEY `FK_D6ADE47F62E883B1`');
        $this->addSql('DROP INDEX IDX_D6ADE47F3BCB2E4B ON epreuve');
        $this->addSql('DROP INDEX IDX_D6ADE47F62E883B1 ON epreuve');
        $this->addSql('ALTER TABLE epreuve ADD id_ue INT NOT NULL, ADD id_nature INT NOT NULL, DROP ue_id, DROP nature_id');
        $this->addSql('ALTER TABLE epreuve ADD CONSTRAINT FK_D6ADE47FEE34F39C FOREIGN KEY (id_ue) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE epreuve ADD CONSTRAINT FK_D6ADE47F97EF374A FOREIGN KEY (id_nature) REFERENCES nature (id)');
        $this->addSql('CREATE INDEX IDX_D6ADE47FEE34F39C ON epreuve (id_ue)');
        $this->addSql('CREATE INDEX IDX_D6ADE47F97EF374A ON epreuve (id_nature)');
        $this->addSql('ALTER TABLE groupe_ue DROP FOREIGN KEY `FK_EB35584762E883B1`');
        $this->addSql('ALTER TABLE groupe_ue DROP FOREIGN KEY `FK_EB3558477A45358C`');
        $this->addSql('DROP INDEX IDX_EB35584762E883B1 ON groupe_ue');
        $this->addSql('DROP INDEX IDX_EB3558477A45358C ON groupe_ue');
        $this->addSql('ALTER TABLE groupe_ue ADD id_groupe INT NOT NULL, ADD id_ue INT NOT NULL, DROP groupe_id, DROP ue_id');
        $this->addSql('ALTER TABLE groupe_ue ADD CONSTRAINT FK_EB355847228E39CC FOREIGN KEY (id_groupe) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE groupe_ue ADD CONSTRAINT FK_EB355847EE34F39C FOREIGN KEY (id_ue) REFERENCES ue (id)');
        $this->addSql('CREATE INDEX IDX_EB355847228E39CC ON groupe_ue (id_groupe)');
        $this->addSql('CREATE INDEX IDX_EB355847EE34F39C ON groupe_ue (id_ue)');
        $this->addSql('ALTER TABLE note_annee DROP FOREIGN KEY `FK_BB826618543EC5F0`');
        $this->addSql('ALTER TABLE note_annee DROP FOREIGN KEY `FK_BB826618DDEAB1A3`');
        $this->addSql('DROP INDEX IDX_BB826618543EC5F0 ON note_annee');
        $this->addSql('DROP INDEX IDX_BB826618DDEAB1A3 ON note_annee');
        $this->addSql('ALTER TABLE note_annee ADD id_etudiant INT NOT NULL, ADD id_annee INT NOT NULL, DROP etudiant_id, DROP annee_id');
        $this->addSql('ALTER TABLE note_annee ADD CONSTRAINT FK_BB82661821A5CE76 FOREIGN KEY (id_etudiant) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE note_annee ADD CONSTRAINT FK_BB826618301784FF FOREIGN KEY (id_annee) REFERENCES annee (id)');
        $this->addSql('CREATE INDEX IDX_BB82661821A5CE76 ON note_annee (id_etudiant)');
        $this->addSql('CREATE INDEX IDX_BB826618301784FF ON note_annee (id_annee)');
        $this->addSql('ALTER TABLE note_division DROP FOREIGN KEY `FK_4C9B8A41859289`');
        $this->addSql('ALTER TABLE note_division DROP FOREIGN KEY `FK_4C9B8ADDEAB1A3`');
        $this->addSql('DROP INDEX IDX_4C9B8A41859289 ON note_division');
        $this->addSql('DROP INDEX IDX_4C9B8ADDEAB1A3 ON note_division');
        $this->addSql('ALTER TABLE note_division ADD id_etudiant INT NOT NULL, ADD id_division INT NOT NULL, DROP etudiant_id, DROP division_id');
        $this->addSql('ALTER TABLE note_division ADD CONSTRAINT FK_4C9B8A21A5CE76 FOREIGN KEY (id_etudiant) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE note_division ADD CONSTRAINT FK_4C9B8A40CCAB81 FOREIGN KEY (id_division) REFERENCES division (id)');
        $this->addSql('CREATE INDEX IDX_4C9B8A21A5CE76 ON note_division (id_etudiant)');
        $this->addSql('CREATE INDEX IDX_4C9B8A40CCAB81 ON note_division (id_division)');
        $this->addSql('ALTER TABLE parcour DROP FOREIGN KEY `FK_B7E529567A4147F0`');
        $this->addSql('DROP INDEX IDX_B7E529567A4147F0 ON parcour');
        $this->addSql('ALTER TABLE parcour CHANGE mention_id id_mention INT NOT NULL');
        $this->addSql('ALTER TABLE parcour ADD CONSTRAINT FK_B7E529563C9FF0BD FOREIGN KEY (id_mention) REFERENCES mention (id)');
        $this->addSql('CREATE INDEX IDX_B7E529563C9FF0BD ON parcour (id_mention)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annee DROP FOREIGN KEY FK_DE92C5CF69788026');
        $this->addSql('DROP INDEX IDX_DE92C5CF69788026 ON annee');
        $this->addSql('ALTER TABLE annee CHANGE id_parcour parcour_id INT NOT NULL');
        $this->addSql('ALTER TABLE annee ADD CONSTRAINT `FK_DE92C5CF9A561E99` FOREIGN KEY (parcour_id) REFERENCES parcour (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DE92C5CF9A561E99 ON annee (parcour_id)');
        $this->addSql('ALTER TABLE annee_user DROP FOREIGN KEY FK_1B4C43636B3CA4B');
        $this->addSql('DROP INDEX IDX_1B4C43636B3CA4B ON annee_user');
        $this->addSql('ALTER TABLE annee_user CHANGE id_user utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE annee_user ADD CONSTRAINT `FK_1B4C4363FB88E14F` FOREIGN KEY (utilisateur_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1B4C4363FB88E14F ON annee_user (utilisateur_id)');
        $this->addSql('ALTER TABLE epreuve DROP FOREIGN KEY FK_D6ADE47FEE34F39C');
        $this->addSql('ALTER TABLE epreuve DROP FOREIGN KEY FK_D6ADE47F97EF374A');
        $this->addSql('DROP INDEX IDX_D6ADE47FEE34F39C ON epreuve');
        $this->addSql('DROP INDEX IDX_D6ADE47F97EF374A ON epreuve');
        $this->addSql('ALTER TABLE epreuve ADD ue_id INT NOT NULL, ADD nature_id INT NOT NULL, DROP id_ue, DROP id_nature');
        $this->addSql('ALTER TABLE epreuve ADD CONSTRAINT `FK_D6ADE47F3BCB2E4B` FOREIGN KEY (nature_id) REFERENCES nature (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE epreuve ADD CONSTRAINT `FK_D6ADE47F62E883B1` FOREIGN KEY (ue_id) REFERENCES ue (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D6ADE47F3BCB2E4B ON epreuve (nature_id)');
        $this->addSql('CREATE INDEX IDX_D6ADE47F62E883B1 ON epreuve (ue_id)');
        $this->addSql('ALTER TABLE groupe_ue DROP FOREIGN KEY FK_EB355847228E39CC');
        $this->addSql('ALTER TABLE groupe_ue DROP FOREIGN KEY FK_EB355847EE34F39C');
        $this->addSql('DROP INDEX IDX_EB355847228E39CC ON groupe_ue');
        $this->addSql('DROP INDEX IDX_EB355847EE34F39C ON groupe_ue');
        $this->addSql('ALTER TABLE groupe_ue ADD groupe_id INT NOT NULL, ADD ue_id INT NOT NULL, DROP id_groupe, DROP id_ue');
        $this->addSql('ALTER TABLE groupe_ue ADD CONSTRAINT `FK_EB35584762E883B1` FOREIGN KEY (ue_id) REFERENCES ue (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE groupe_ue ADD CONSTRAINT `FK_EB3558477A45358C` FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_EB35584762E883B1 ON groupe_ue (ue_id)');
        $this->addSql('CREATE INDEX IDX_EB3558477A45358C ON groupe_ue (groupe_id)');
        $this->addSql('ALTER TABLE note_annee DROP FOREIGN KEY FK_BB82661821A5CE76');
        $this->addSql('ALTER TABLE note_annee DROP FOREIGN KEY FK_BB826618301784FF');
        $this->addSql('DROP INDEX IDX_BB82661821A5CE76 ON note_annee');
        $this->addSql('DROP INDEX IDX_BB826618301784FF ON note_annee');
        $this->addSql('ALTER TABLE note_annee ADD etudiant_id INT DEFAULT NULL, ADD annee_id INT DEFAULT NULL, DROP id_etudiant, DROP id_annee');
        $this->addSql('ALTER TABLE note_annee ADD CONSTRAINT `FK_BB826618543EC5F0` FOREIGN KEY (annee_id) REFERENCES annee (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE note_annee ADD CONSTRAINT `FK_BB826618DDEAB1A3` FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BB826618543EC5F0 ON note_annee (annee_id)');
        $this->addSql('CREATE INDEX IDX_BB826618DDEAB1A3 ON note_annee (etudiant_id)');
        $this->addSql('ALTER TABLE note_division DROP FOREIGN KEY FK_4C9B8A21A5CE76');
        $this->addSql('ALTER TABLE note_division DROP FOREIGN KEY FK_4C9B8A40CCAB81');
        $this->addSql('DROP INDEX IDX_4C9B8A21A5CE76 ON note_division');
        $this->addSql('DROP INDEX IDX_4C9B8A40CCAB81 ON note_division');
        $this->addSql('ALTER TABLE note_division ADD etudiant_id INT NOT NULL, ADD division_id INT NOT NULL, DROP id_etudiant, DROP id_division');
        $this->addSql('ALTER TABLE note_division ADD CONSTRAINT `FK_4C9B8A41859289` FOREIGN KEY (division_id) REFERENCES division (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE note_division ADD CONSTRAINT `FK_4C9B8ADDEAB1A3` FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4C9B8A41859289 ON note_division (division_id)');
        $this->addSql('CREATE INDEX IDX_4C9B8ADDEAB1A3 ON note_division (etudiant_id)');
        $this->addSql('ALTER TABLE parcour DROP FOREIGN KEY FK_B7E529563C9FF0BD');
        $this->addSql('DROP INDEX IDX_B7E529563C9FF0BD ON parcour');
        $this->addSql('ALTER TABLE parcour CHANGE id_mention mention_id INT NOT NULL');
        $this->addSql('ALTER TABLE parcour ADD CONSTRAINT `FK_B7E529567A4147F0` FOREIGN KEY (mention_id) REFERENCES mention (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B7E529567A4147F0 ON parcour (mention_id)');
    }
}
