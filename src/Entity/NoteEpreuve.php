<?php

namespace App\Entity;

use App\Enum\StatutAbsence;
use App\Repository\NoteEpreuveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteEpreuveRepository::class)]
#[ORM\UniqueConstraint(name: 'etudiant_epreuve_unique', columns: ['id_etudiant', 'id_epreuve'])]
class NoteEpreuve
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

    #[ORM\Column(type: Types::STRING, length: 20, nullable: true, enumType: StatutAbsence::class)]
    private ?StatutAbsence $absence = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarque = null;

    #[ORM\ManyToOne(inversedBy: 'noteEpreuves')]
    #[ORM\JoinColumn(name: 'id_etudiant', nullable: false)]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'noteEpreuves')]
    #[ORM\JoinColumn(name: 'id_epreuve', nullable: false)]
    private ?Epreuve $epreuve = null;

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

    public function getAbsence(): ?StatutAbsence
    {
        return $this->absence;
    }

    public function setAbsence(StatutAbsence $absence): static
    {
        $this->absence = $absence;
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

    public function getEpreuve(): ?Epreuve
    {
        return $this->epreuve;
    }

    public function setEpreuve(?Epreuve $epreuve): static
    {
        $this->epreuve = $epreuve;

        return $this;
    }
}
