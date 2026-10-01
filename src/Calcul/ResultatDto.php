<?php
namespace App\Calcul;

final class ResultatDto
{
    public function __construct(
        public readonly ?float $moyenne,
        public readonly bool $estComplet,
    )
    {}
}