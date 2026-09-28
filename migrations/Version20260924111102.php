<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260924111102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annee (id INT AUTO_INCREMENT NOT NULL, an INT NOT NULL, nom VARCHAR(100) NOT NULL, nom_court VARCHAR(20) DEFAULT NULL, is_compensable TINYINT NOT NULL, moyenne_validation DOUBLE PRECISION NOT NULL, remarque LONGTEXT DEFAULT NULL, parcour_id INT NOT NULL, INDEX IDX_DE92C5CF9A561E99 (parcour_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE annee_user (id INT AUTO_INCREMENT NOT NULL, droit VARCHAR(50) NOT NULL, remarque LONGTEXT DEFAULT NULL, utilisateur_id INT NOT NULL, annee_id INT DEFAULT NULL, INDEX IDX_1B4C4363FB88E14F (utilisateur_id), INDEX IDX_1B4C4363543EC5F0 (annee_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE calcul (id INT AUTO_INCREMENT NOT NULL, formule VARCHAR(255) NOT NULL, remarque LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE config (id INT AUTO_INCREMENT NOT NULL, annee VARCHAR(100) NOT NULL, responsable VARCHAR(200) DEFAULT NULL, webmaster VARCHAR(200) DEFAULT NULL, is_actif TINYINT NOT NULL, remarque LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE diplome (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, nom_court VARCHAR(20) DEFAULT NULL, rang INT NOT NULL, remarque LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE division (id INT AUTO_INCREMENT NOT NULL, num INT NOT NULL, nom VARCHAR(20) NOT NULL, moyenne_validation DOUBLE PRECISION NOT NULL, moyenne_minimal DOUBLE PRECISION DEFAULT NULL, remarque LONGTEXT DEFAULT NULL, annee_id INT NOT NULL, groupe_id INT NOT NULL, UNIQUE INDEX UNIQ_101747147A45358C (groupe_id), INDEX IDX_10174714543EC5F0 (annee_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE epreuve (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, nom VARCHAR(100) NOT NULL, coefficient DOUBLE PRECISION NOT NULL, moyenne_minimale DOUBLE PRECISION DEFAULT NULL, duree INT DEFAULT NULL, remarque LONGTEXT DEFAULT NULL, ue_id INT NOT NULL, nature_id INT NOT NULL, INDEX IDX_D6ADE47F62E883B1 (ue_id), INDEX IDX_D6ADE47F3BCB2E4B (nature_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, remarque LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(20) NOT NULL, ects DOUBLE PRECISION DEFAULT NULL, nom VARCHAR(100) DEFAULT NULL, moyenne_minimale DOUBLE PRECISION DEFAULT NULL, remarque LONGTEXT DEFAULT NULL, id_parent INT DEFAULT NULL, INDEX IDX_4B98C211BB9D5A2 (id_parent), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE groupe_ue (id INT AUTO_INCREMENT NOT NULL, remarque LONGTEXT DEFAULT NULL, groupe_id INT NOT NULL, ue_id INT NOT NULL, INDEX IDX_EB3558477A45358C (groupe_id), INDEX IDX_EB35584762E883B1 (ue_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE mention (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, nom_court VARCHAR(20) DEFAULT NULL, rang INT NOT NULL, remarque LONGTEXT DEFAULT NULL, id_diplome INT NOT NULL, UNIQUE INDEX UNIQ_E20259CD81CFA4CE (rang), UNIQUE INDEX nom_diplome_unique (nom, id_diplome), INDEX IDX_E20259CD35D1E43E (id_diplome), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nature (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE note_annee (id INT AUTO_INCREMENT NOT NULL, note DOUBLE PRECISION DEFAULT NULL, neutralis_note_mini TINYINT NOT NULL, points_jury DOUBLE PRECISION DEFAULT NULL, bonus DOUBLE PRECISION DEFAULT NULL, remarque LONGTEXT DEFAULT NULL, etudiant_id INT DEFAULT NULL, annee_id INT DEFAULT NULL, INDEX IDX_BB826618DDEAB1A3 (etudiant_id), INDEX IDX_BB826618543EC5F0 (annee_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE note_division (id INT AUTO_INCREMENT NOT NULL, note DOUBLE PRECISION DEFAULT NULL, neutralise_note_mini TINYINT NOT NULL, points_jury DOUBLE PRECISION DEFAULT NULL, is_dispense TINYINT NOT NULL, remarque LONGTEXT DEFAULT NULL, etudiant_id INT NOT NULL, division_id INT NOT NULL, INDEX IDX_4C9B8ADDEAB1A3 (etudiant_id), INDEX IDX_4C9B8A41859289 (division_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE note_epreuve (id INT AUTO_INCREMENT NOT NULL, note DOUBLE PRECISION DEFAULT NULL, neutralise_note_mini TINYINT NOT NULL, points_jury DOUBLE PRECISION DEFAULT NULL, is_dispense TINYINT NOT NULL, absence VARCHAR(20) DEFAULT NULL, remarque LONGTEXT DEFAULT NULL, id_etudiant INT NOT NULL, id_epreuve INT NOT NULL, UNIQUE INDEX etudiant_epreuve_unique (id_etudiant, id_epreuve), INDEX IDX_570B20E521A5CE76 (id_etudiant), INDEX IDX_570B20E58304D0F (id_epreuve), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE note_groupe (id INT AUTO_INCREMENT NOT NULL, note DOUBLE PRECISION DEFAULT NULL, neutralis_note_mini TINYINT NOT NULL, points_jury DOUBLE PRECISION DEFAULT NULL, is_dispense TINYINT NOT NULL, remarque LONGTEXT DEFAULT NULL, etudiant_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_1C6BDBF5DDEAB1A3 (etudiant_id), INDEX IDX_1C6BDBF57A45358C (groupe_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE note_ue (id INT AUTO_INCREMENT NOT NULL, note DOUBLE PRECISION DEFAULT NULL, neutralis_note_mini TINYINT NOT NULL, points_jury DOUBLE PRECISION DEFAULT NULL, is_dispense TINYINT NOT NULL, remarque LONGTEXT NOT NULL, etudiant_id INT NOT NULL, ue_id INT NOT NULL, INDEX IDX_B79D659EDDEAB1A3 (etudiant_id), INDEX IDX_B79D659E62E883B1 (ue_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE parcour (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, nom_court VARCHAR(20) DEFAULT NULL, rang INT NOT NULL, remarque LONGTEXT DEFAULT NULL, mention_id INT NOT NULL, INDEX IDX_B7E529567A4147F0 (mention_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ue (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(200) NOT NULL, nom_court VARCHAR(20) DEFAULT NULL, ects DOUBLE PRECISION NOT NULL, moyenne_validation DOUBLE PRECISION NOT NULL, moyenne_minimale DOUBLE PRECISION DEFAULT NULL, code_apogee VARCHAR(50) DEFAULT NULL, code_ose VARCHAR(50) DEFAULT NULL, remarque LONGTEXT DEFAULT NULL, id_calcul INT NOT NULL, INDEX IDX_2E490A9B90EAAA45 (id_calcul), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(200) DEFAULT NULL, remarque LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN (login), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE annee ADD CONSTRAINT FK_DE92C5CF9A561E99 FOREIGN KEY (parcour_id) REFERENCES parcour (id)');
        $this->addSql('ALTER TABLE annee_user ADD CONSTRAINT FK_1B4C4363FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE annee_user ADD CONSTRAINT FK_1B4C4363543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE division ADD CONSTRAINT FK_10174714543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE division ADD CONSTRAINT FK_101747147A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE epreuve ADD CONSTRAINT FK_D6ADE47F62E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE epreuve ADD CONSTRAINT FK_D6ADE47F3BCB2E4B FOREIGN KEY (nature_id) REFERENCES nature (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C211BB9D5A2 FOREIGN KEY (id_parent) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE groupe_ue ADD CONSTRAINT FK_EB3558477A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE groupe_ue ADD CONSTRAINT FK_EB35584762E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE mention ADD CONSTRAINT FK_E20259CD35D1E43E FOREIGN KEY (id_diplome) REFERENCES diplome (id)');
        $this->addSql('ALTER TABLE note_annee ADD CONSTRAINT FK_BB826618DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE note_annee ADD CONSTRAINT FK_BB826618543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE note_division ADD CONSTRAINT FK_4C9B8ADDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE note_division ADD CONSTRAINT FK_4C9B8A41859289 FOREIGN KEY (division_id) REFERENCES division (id)');
        $this->addSql('ALTER TABLE note_epreuve ADD CONSTRAINT FK_570B20E521A5CE76 FOREIGN KEY (id_etudiant) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE note_epreuve ADD CONSTRAINT FK_570B20E58304D0F FOREIGN KEY (id_epreuve) REFERENCES epreuve (id)');
        $this->addSql('ALTER TABLE note_groupe ADD CONSTRAINT FK_1C6BDBF5DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE note_groupe ADD CONSTRAINT FK_1C6BDBF57A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE note_ue ADD CONSTRAINT FK_B79D659EDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE note_ue ADD CONSTRAINT FK_B79D659E62E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE parcour ADD CONSTRAINT FK_B7E529567A4147F0 FOREIGN KEY (mention_id) REFERENCES mention (id)');
        $this->addSql('ALTER TABLE ue ADD CONSTRAINT FK_2E490A9B90EAAA45 FOREIGN KEY (id_calcul) REFERENCES calcul (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annee DROP FOREIGN KEY FK_DE92C5CF9A561E99');
        $this->addSql('ALTER TABLE annee_user DROP FOREIGN KEY FK_1B4C4363FB88E14F');
        $this->addSql('ALTER TABLE annee_user DROP FOREIGN KEY FK_1B4C4363543EC5F0');
        $this->addSql('ALTER TABLE division DROP FOREIGN KEY FK_10174714543EC5F0');
        $this->addSql('ALTER TABLE division DROP FOREIGN KEY FK_101747147A45358C');
        $this->addSql('ALTER TABLE epreuve DROP FOREIGN KEY FK_D6ADE47F62E883B1');
        $this->addSql('ALTER TABLE epreuve DROP FOREIGN KEY FK_D6ADE47F3BCB2E4B');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C211BB9D5A2');
        $this->addSql('ALTER TABLE groupe_ue DROP FOREIGN KEY FK_EB3558477A45358C');
        $this->addSql('ALTER TABLE groupe_ue DROP FOREIGN KEY FK_EB35584762E883B1');
        $this->addSql('ALTER TABLE mention DROP FOREIGN KEY FK_E20259CD35D1E43E');
        $this->addSql('ALTER TABLE note_annee DROP FOREIGN KEY FK_BB826618DDEAB1A3');
        $this->addSql('ALTER TABLE note_annee DROP FOREIGN KEY FK_BB826618543EC5F0');
        $this->addSql('ALTER TABLE note_division DROP FOREIGN KEY FK_4C9B8ADDEAB1A3');
        $this->addSql('ALTER TABLE note_division DROP FOREIGN KEY FK_4C9B8A41859289');
        $this->addSql('ALTER TABLE note_epreuve DROP FOREIGN KEY FK_570B20E521A5CE76');
        $this->addSql('ALTER TABLE note_epreuve DROP FOREIGN KEY FK_570B20E58304D0F');
        $this->addSql('ALTER TABLE note_groupe DROP FOREIGN KEY FK_1C6BDBF5DDEAB1A3');
        $this->addSql('ALTER TABLE note_groupe DROP FOREIGN KEY FK_1C6BDBF57A45358C');
        $this->addSql('ALTER TABLE note_ue DROP FOREIGN KEY FK_B79D659EDDEAB1A3');
        $this->addSql('ALTER TABLE note_ue DROP FOREIGN KEY FK_B79D659E62E883B1');
        $this->addSql('ALTER TABLE parcour DROP FOREIGN KEY FK_B7E529567A4147F0');
        $this->addSql('ALTER TABLE ue DROP FOREIGN KEY FK_2E490A9B90EAAA45');
        $this->addSql('DROP TABLE annee');
        $this->addSql('DROP TABLE annee_user');
        $this->addSql('DROP TABLE calcul');
        $this->addSql('DROP TABLE config');
        $this->addSql('DROP TABLE diplome');
        $this->addSql('DROP TABLE division');
        $this->addSql('DROP TABLE epreuve');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE groupe_ue');
        $this->addSql('DROP TABLE mention');
        $this->addSql('DROP TABLE nature');
        $this->addSql('DROP TABLE note_annee');
        $this->addSql('DROP TABLE note_division');
        $this->addSql('DROP TABLE note_epreuve');
        $this->addSql('DROP TABLE note_groupe');
        $this->addSql('DROP TABLE note_ue');
        $this->addSql('DROP TABLE parcour');
        $this->addSql('DROP TABLE ue');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
