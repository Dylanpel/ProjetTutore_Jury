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
    public function testMoyennePondereeDeDeuxEpreuves():void
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

    private function creerNoteEpreuve(
        Etudiant $etudiant,
        float $coefficient,
        ?float $note,
    ): NoteEpreuve {
        $epreuve = (new Epreuve())
            ->setNom('Epreuve')
            ->setNumero(1)
            ->setCoefficient($coefficient);

        return (new NoteEpreuve())
            ->setEtudiant($etudiant)
            ->setEpreuve($epreuve)
            ->setNote($note)
            ->setIsDispense(false)
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