<?php

namespace App\Entity;

use App\Repository\NoteAnneeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteAnneeRepository::class)]
class NoteAnnee
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

    #[ORM\Column(nullable: true)]
    private ?float $bonus = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarque = null;

    #[ORM\ManyToOne(inversedBy: 'noteAnnees')]
    #[ORM\JoinColumn(name: 'id_etudiant', nullable: false)]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'noteAnnees')]
    #[ORM\JoinColumn(name: 'id_annee', nullable: false)]
    private ?Annee $annee = null;

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

    public function getBonus(): ?float
    {
        return $this->bonus;
    }

    public function setBonus(?float $bonus): static
    {
        $this->bonus = $bonus;

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

    public function getAnnee(): ?Annee
    {
        return $this->annee;
    }

    public function setAnnee(?Annee $annee): static
    {
        $this->annee = $annee;

        return $this;
    }
}
