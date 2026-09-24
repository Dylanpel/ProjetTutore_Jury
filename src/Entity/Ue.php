<?php

namespace App\Entity;

use App\Repository\UeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UeRepository::class)]
class Ue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $nom = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $nom_court = null;

    #[ORM\Column]
    private ?float $ects = null;

    #[ORM\Column]
    private ?float $moyenne_validation = null;

    #[ORM\Column(nullable: true)]
    private ?float $moyenne_minimale = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $code_apogee = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $code_ose = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarque = null;

    #[ORM\ManyToOne(inversedBy: 'ues')]
    #[ORM\JoinColumn(name: 'id_calcul', nullable: false)]
    private ?Calcul $calcul = null;

    /**
     * @var Collection<int, Epreuve>
     */
    #[ORM\OneToMany(targetEntity: Epreuve::class, mappedBy: 'ue')]
    private Collection $epreuves;

    /**
     * @var Collection<int, GroupeUe>
     */
    #[ORM\OneToMany(targetEntity: GroupeUe::class, mappedBy: 'ue')]
    private Collection $groupeUes;

    /**
     * @var Collection<int, NoteUe>
     */
    #[ORM\OneToMany(targetEntity: NoteUe::class, mappedBy: 'ue')]
    private Collection $noteUes;

    public function __construct()
    {
        $this->epreuves = new ArrayCollection();
        $this->groupeUes = new ArrayCollection();
        $this->noteUes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNomCourt(): ?string
    {
        return $this->nom_court;
    }

    public function setNomCourt(?string $nom_court): static
    {
        $this->nom_court = $nom_court;

        return $this;
    }

    public function getEcts(): ?float
    {
        return $this->ects;
    }

    public function setEcts(float $ects): static
    {
        $this->ects = $ects;

        return $this;
    }

    public function getMoyenneValidation(): ?float
    {
        return $this->moyenne_validation;
    }

    public function setMoyenneValidation(float $moyenne_validation): static
    {
        $this->moyenne_validation = $moyenne_validation;

        return $this;
    }

    public function getMoyenneMinimale(): ?float
    {
        return $this->moyenne_minimale;
    }

    public function setMoyenneMinimale(?float $moyenne_minimale): static
    {
        $this->moyenne_minimale = $moyenne_minimale;

        return $this;
    }

    public function getCodeApogee(): ?string
    {
        return $this->code_apogee;
    }

    public function setCodeApogee(?string $code_apogee): static
    {
        $this->code_apogee = $code_apogee;

        return $this;
    }

    public function getCodeOse(): ?string
    {
        return $this->code_ose;
    }

    public function setCodeOse(?string $code_ose): static
    {
        $this->code_ose = $code_ose;

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

    public function getCalcul(): ?Calcul
    {
        return $this->calcul;
    }

    public function setCalcul(?Calcul $calcul): static
    {
        $this->calcul = $calcul;

        return $this;
    }

    /**
     * @return Collection<int, Epreuve>
     */
    public function getEpreuves(): Collection
    {
        return $this->epreuves;
    }

    public function addEpreufe(Epreuve $epreufe): static
    {
        if (!$this->epreuves->contains($epreufe)) {
            $this->epreuves->add($epreufe);
            $epreufe->setUe($this);
        }

        return $this;
    }

    public function removeEpreufe(Epreuve $epreufe): static
    {
        if ($this->epreuves->removeElement($epreufe)) {
            // set the owning side to null (unless already changed)
            if ($epreufe->getUe() === $this) {
                $epreufe->setUe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GroupeUe>
     */
    public function getGroupeUes(): Collection
    {
        return $this->groupeUes;
    }

    public function addGroupeUe(GroupeUe $groupeUe): static
    {
        if (!$this->groupeUes->contains($groupeUe)) {
            $this->groupeUes->add($groupeUe);
            $groupeUe->setUe($this);
        }

        return $this;
    }

    public function removeGroupeUe(GroupeUe $groupeUe): static
    {
        if ($this->groupeUes->removeElement($groupeUe)) {
            // set the owning side to null (unless already changed)
            if ($groupeUe->getUe() === $this) {
                $groupeUe->setUe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NoteUe>
     */
    public function getNoteUes(): Collection
    {
        return $this->noteUes;
    }

    public function addNoteUe(NoteUe $noteUe): static
    {
        if (!$this->noteUes->contains($noteUe)) {
            $this->noteUes->add($noteUe);
            $noteUe->setUe($this);
        }

        return $this;
    }

    public function removeNoteUe(NoteUe $noteUe): static
    {
        if ($this->noteUes->removeElement($noteUe)) {
            // set the owning side to null (unless already changed)
            if ($noteUe->getUe() === $this) {
                $noteUe->setUe(null);
            }
        }

        return $this;
    }
}
