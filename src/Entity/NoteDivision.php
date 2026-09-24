<?php

namespace App\Entity;

use App\Repository\NoteDivisionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteDivisionRepository::class)]
class NoteDivision
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $note = null;

    #[ORM\Column]
    private ?bool $neutraliseNoteMini = null;

    #[ORM\Column(nullable: true)]
    private ?float $pointsJury = null;

    #[ORM\Column]
    private ?bool $isDispense = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarque = null;

    #[ORM\ManyToOne(inversedBy: 'noteDivisions')]
    #[ORM\JoinColumn(name: 'id_etudiant', nullable: false)]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'noteDivisions')]
    #[ORM\JoinColumn(name: 'id_division', nullable: false)]
    private ?Division $division = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function isNeutraliseNoteMini(): ?bool
    {
        return $this->neutraliseNoteMini;
    }

    public function setNeutraliseNoteMini(bool $neutraliseNoteMini): static
    {
        $this->neutraliseNoteMini = $neutraliseNoteMini;

        return $this;
    }

    public function getPointsJury(): ?float
    {
        return $this->pointsJury;
    }

    public function setPointsJury(?float $pointsJury): static
    {
        $this->pointsJury = $pointsJury;

        return $this;
    }

    public function isDispense(): ?bool
    {
        return $this->isDispense;
    }

    public function setIsDispense(bool $isDispense): static
    {
        $this->isDispense = $isDispense;

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): static
    {
        $this->remarque = $remarque;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): static
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getDivision(): ?Division
    {
        return $this->division;
    }

    public function setDivision(?Division $division): static
    {
        $this->division = $division;

        return $this;
    }
}
