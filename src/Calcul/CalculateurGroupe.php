<?php

namespace App\Calcul;

use App\Entity\Groupe;
use App\Entity\NoteGroupe;
use App\Repository\NoteGroupeRepository;
use App\Repository\NoteUeRepository;

class CalculateurGroupe
{
    public function __construct(
        private readonly CalculateurUe $calculateurUe,
        private readonly NoteUeRepository $noteUeRepository,
        private readonly NoteGroupeRepository $noteGroupeRepository,
    ) {
    }

    /**
     * Calcule la moyenne d'un groupe pour un étudiant.
     *
     * Une note saisie directement sur le groupe prime sur le calcul.
     * La moyenne est pondérée par les ECTS des UEs et sous-groupes suivis.
     * Un élément dispensé est exclu de la moyenne, mais ses ECTS comptent
     * dans le contrôle des ECTS suivis.
     */
    public function calculerGroupe(NoteGroupe $noteGroupe): ResultatDto
    {
        // Une note saisie directement prime sur le calcul
        if ($noteGroupe->getNote() !== null) {
            return new ResultatDto(
                $this->appliquerPoints($noteGroupe->getNote(), $noteGroupe->getPointsJury()),
                true
            );
        }

        $etudiant = $noteGroupe->getEtudiant();
        $groupe = $noteGroupe->getGroupe();

        $sommeNotes = 0.0;
        $sommeCoefs = 0.0;
        $ectsSuivis = 0.0;

        // Les UEs de ce groupe suivies par l'étudiant
        foreach ($this->noteUeRepository->findByEtudiantAndGroupe($etudiant, $groupe) as $noteUe) {
            $coefficient = $noteUe->getUe()->getEcts();
            $ectsSuivis += $coefficient;

            if ($noteUe->isDispense()) {
                continue;
            }

            $resultat = $this->calculateurUe->calculerUe($noteUe);

            if (!$resultat->estComplet) {
                return new ResultatDto(null, false);
            }

            $sommeNotes += $resultat->moyenne * $coefficient;
            $sommeCoefs += $coefficient;
        }

        // Les sous-groupes suivis par l'étudiant (récursion)
        foreach ($this->noteGroupeRepository->findByEtudiantAndParent($etudiant, $groupe) as $noteEnfant) {
            $coefficient = $this->getEctsGroupe($noteEnfant->getGroupe());
            $ectsSuivis += $coefficient;

            if ($noteEnfant->isDispense()) {
                continue;
            }

            $resultat = $this->calculerGroupe($noteEnfant);

            if (!$resultat->estComplet) {
                return new ResultatDto(null, false);
            }

            $sommeNotes += $resultat->moyenne * $coefficient;
            $sommeCoefs += $coefficient;
        }

        // Il manque une ligne de note, ou les choix ne font pas le compte d'ECTS
        if (abs($ectsSuivis - $this->getEctsGroupe($groupe)) > 0.001) {
            return new ResultatDto(null, false);
        }

        // Aucun élément retenu : rien à calculer
        if ($sommeCoefs === 0.0) {
            return new ResultatDto(null, false);
        }

        return new ResultatDto(
            $this->appliquerPoints($sommeNotes / $sommeCoefs, $noteGroupe->getPointsJury()),
            true,
        );
    }

    /**
     * Retourne les ECTS d'un groupe, qui servent de coefficient dans son parent.
     * Pour un groupe "choix parmi", la valeur est stockée. Pour un groupe
     * "obligatoire", elle est la somme des ECTS de ses éléments (récursif).
     */
    private function getEctsGroupe(Groupe $groupe): float
    {
        if ($groupe->getEcts() !== null) {
            return $groupe->getEcts();
        }

        $total = 0.0;

        foreach ($groupe->getGroupeUes() as $groupeUe) {
            $total += $groupeUe->getUe()->getEcts();
        }

        foreach ($groupe->getEnfants() as $enfant) {
            $total += $this->getEctsGroupe($enfant);
        }

        return $total;
    }

    /**
    * Rajoute les points du jury à la note
    */
    private function appliquerPoints(float $note, ?float $pointsJury): float
    {
        return $note + ($pointsJury ?? 0.0);
    }
}
