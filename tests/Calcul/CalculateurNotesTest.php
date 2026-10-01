<?php

namespace App\Tests\Calcul;

use App\Calcul\CalculateurNotes;
use App\Entity\Epreuve;
use App\Entity\Etudiant;
use App\Entity\NoteEpreuve;
use App\Entity\NoteUe;
use App\Entity\Ue;
use App\Repository\NoteEpreuveRepository;
use PHPUnit\Framework\TestCase;

class CalculateurNotesTest extends TestCase
{
    public function testMoyennePondereeDeDeuxEpreuves(): void
    {
        //ARRANGE

        $ue = (new Ue())->setNom('Algo')->setEcts(6);
        $etudiant = new Etudiant();

        $noteUe = (new NoteUe())->setUe($ue)->setEtudiant($etudiant);

        $notesEpreuves = [
            $this->creerNoteEpreuve($etudiant, coefficient:1, note:8),
            $this->creerNoteEpreuve($etudiant, coefficient:3, note:12),
        ];

        //ACT
        $calculateur = new CalculateurNotes(
            $this->creerRepository($notesEpreuves),
        );

        $resultat = $calculateur->calculerUe($noteUe);

        //ASSERT
        // (8x1 + 12x3) / (1+3) = 44/4 = 11
        $this->assertSame(11.0, $resultat->moyenne);
        $this->assertTrue($resultat->estComplet);
    }

    public function testNoteSaisiePrimeSurEpreuve(): void
    {
        //ARRANGE

        $ue = (new Ue())->setNom('Algo')->setEcts(6);
        $etudiant = new Etudiant();

        $noteUe = (new NoteUe())->setUe($ue)->setEtudiant($etudiant)->setNote(15);

        $notesEpreuves = [
            $this->creerNoteEpreuve($etudiant, coefficient:1, note:8),
            $this->creerNoteEpreuve($etudiant, coefficient:3, note:12),
        ];

        //ACT
        $calculateur = new CalculateurNotes(
            $this->creerRepository($notesEpreuves),
        );

        $resultat = $calculateur->calculerUe($noteUe);

        //ASSERT
        // le calcul des notes font bien 11 mais on à saisie à la main 15 elle doit donc primer sur tout le reste.
        $this->assertSame(15.0, $resultat->moyenne);
        $this->assertTrue($resultat->estComplet);
    }

    public function testEpreuveDispenseExcluCalcul(): void
    {
        //ARRANGE

        $ue = (new Ue())->setNom('Algo')->setEcts(6);
        $etudiant = new Etudiant();

        $noteUe = (new NoteUe())->setUe($ue)->setEtudiant($etudiant);

        $notesEpreuves = [
            $this->creerNoteEpreuve($etudiant, coefficient:1, note:8),
            $this->creerNoteEpreuve($etudiant, coefficient:3, note:12),
            $this->creerNoteEpreuve($etudiant, coefficient:4, note:5, dispense:true),
        ];

        //ACT
        $calculateur = new CalculateurNotes(
            $this->creerRepository($notesEpreuves),
        );

        $resultat = $calculateur->calculerUe($noteUe);

        //ASSERT
        // (8x1 + 12x3) / (1+3) = 44/4 + (on ignore la troisième note ) = 11
        $this->assertSame(11.0, $resultat->moyenne);
        $this->assertTrue($resultat->estComplet);
    }

    public function testNoteManquanteRendLeResultatIncomplet(): void
    {
        //ARRANGE

        $ue = (new Ue())->setNom('Algo')->setEcts(6);
        $etudiant = new Etudiant();

        $noteUe = (new NoteUe())->setUe($ue)->setEtudiant($etudiant);

        $notesEpreuves = [
            $this->creerNoteEpreuve($etudiant, coefficient:1, note:8),
            $this->creerNoteEpreuve($etudiant, coefficient:3, note:12),
            $this->creerNoteEpreuve($etudiant, coefficient:4, note:null),
        ];

        //ACT
        $calculateur = new CalculateurNotes(
            $this->creerRepository($notesEpreuves),
        );

        $resultat = $calculateur->calculerUe($noteUe);

        //ASSERT
        // Une note null donc le resultat est incomplet et renvoie null
        $this->assertNull($resultat->moyenne);
        $this->assertFalse($resultat->estComplet);
    }

    public function testToutesEpreuvesDispenseesDonneAucuneMoyenne(): void
    {
        //ARRANGE

        $ue = (new Ue())->setNom('Algo')->setEcts(6);
        $etudiant = new Etudiant();

        $noteUe = (new NoteUe())->setUe($ue)->setEtudiant($etudiant);

        $notesEpreuves = [
            $this->creerNoteEpreuve($etudiant, coefficient:1, note:8, dispense:true),
            $this->creerNoteEpreuve($etudiant, coefficient:3, note:12, dispense:true),
            $this->creerNoteEpreuve($etudiant, coefficient:4, note:11, dispense:true),
        ];

        //ACT
        $calculateur = new CalculateurNotes(
            $this->creerRepository($notesEpreuves),
        );

        $resultat = $calculateur->calculerUe($noteUe);

        //ASSERT
        // Toute les notes sont dispensé, le resultat est donc incomplet et renvoie null
        $this->assertNull($resultat->moyenne);
        $this->assertFalse($resultat->estComplet);
    }

    private function creerNoteEpreuve(
        Etudiant $etudiant,
        float $coefficient,
        ?float $note,
        bool $dispense = false,
    ): NoteEpreuve {
        $epreuve = (new Epreuve())
            ->setNom('Epreuve')
            ->setNumero(1)
            ->setCoefficient($coefficient);

        return (new NoteEpreuve())
            ->setEtudiant($etudiant)
            ->setEpreuve($epreuve)
            ->setNote($note)
            ->setIsDispense($dispense)
            ->setNeutraliseNoteMini(false);
    }

    /**
     * @param NoteEpreuve[] $notesEpreuves
     */
    private function creerRepository(array $notesEpreuves): NoteEpreuveRepository
    {
        $repository = $this->createMock(NoteEpreuveRepository::class);
        $repository->method('findByEtudiantAndUe')->willReturn($notesEpreuves);

        return $repository;
    }
}
