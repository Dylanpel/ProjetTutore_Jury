<?php

namespace App\Entity;

use App\Repository\NoteUeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteUeRepository::class)]
class NoteUe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $note = null;

    #[ORM\Column]
    private ?bool $neutralisNoteMini = null;

    #[ORM\Column(nullable: true)]
    private ?float $pointsJury = null;

    #[ORM\Column]
    private ?bool $isDispense = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $remarque = null;

    #[ORM\ManyToOne(inversedBy: 'noteUes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'noteUes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ue $ue = null;

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

    public function isNeutralisNoteMini(): ?bool
    {
        return $this->neutralisNoteMini;
    }

    public function setNeutralisNoteMini(bool $neutralisNoteMini): static
    {
        $this->neutralisNoteMini = $neutralisNoteMini;

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

    public function setRemarque(string $remarque): static
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

    public function getUe(): ?Ue
    {
        return $this->ue;
    }

    public function setUe(?Ue $ue): static
    {
        $this->ue = $ue;

        return $this;
    }
}
