<?php

namespace App\Calcul;

use App\Entity\NoteUe;
use App\Entity\NoteEpreuve;
use App\Repository\NoteEpreuveRepository;

class CalculateurNotes
{

    public function __construct(
        private readonly NoteEpreuveRepository $noteEpreuveRepository, 
    )
    {
    }

    /**
    * Calcule la moyenne d'une UE pour un étudiant.
    *
    * Une note saisie directement sur l'UE prime sur le calcul des épreuves.
    * Les épreuves dispensées sont exclues, note et coefficient compris.
    * Si une note d'épreuve est manquante, aucune moyenne n'est produite.
    */
    public function calculerUe(NoteUe $noteUe): ResultatDto
    {
        /*
         * Return la note rentrer mannuellement si elle existe, car elle prime sur tout et pas besoins de calculer les épreuves.
         */
        if ($noteUe->getNote() !== null) {
            return new ResultatDto(
                $this->appliquerPoints($noteUe->getNote(), $noteUe->getPointsJury()),
                true
            );
        }

        $sommeNotes = 0.0;
        $sommeCoefs = 0.0;

        foreach ($this->getNotesEpreuves($noteUe) as $noteEpreuve) {

            // 3. Une épreuve dispensée sort du calcul, coefficient compris
            if ($noteEpreuve->isDispense()) {
                continue;
            }

            // 4. Une note manquante rend le résultat incomplet
            if ($noteEpreuve->getNote() === null) {
                return new ResultatDto(null, false);
            }

            $coefficient = $noteEpreuve->getEpreuve()->getCoefficient();
            $note = $this->appliquerPoints($noteEpreuve->getNote(), $noteEpreuve->getPointsJury());

            $sommeNotes += $note * $coefficient;
            $sommeCoefs += $coefficient;
        }

        // Aucune épreuve retenue : rien à calculer
        if ($sommeCoefs === 0.0) {
            return new ResultatDto(null, false);
        }

        $moyenne = $sommeNotes / $sommeCoefs;

        return new ResultatDto(
            $this->appliquerPoints($moyenne, $noteUe->getPointsJury()),
            true,
        );
    }

    /**
    * Rajoute les points du jury à la note
    */
    private function appliquerPoints(float $note, ?float $pointsJury): float
    {
        return $note + ($pointsJury ?? 0.0);
    }

    /**
     * @return NoteEpreuve[]
     */
    private function getNotesEpreuves(NoteUe $noteUe) : array
    {
        return $this->noteEpreuveRepository->findByEtudiantAndUe(
            $noteUe->getEtudiant(),
            $noteUe->getUe(),
        );
    }
}
