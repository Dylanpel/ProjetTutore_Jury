<?php

namespace App\Calcul;

use App\Entity\NoteUe;

class CalculateurNotes
{
    public function calculerUe(NoteUe $noteUe): ResultatDto
    {
        return new ResultatDto(null, false);
    }
}