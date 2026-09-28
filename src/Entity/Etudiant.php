<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarque = null;

    /**
     * @var Collection<int, NoteAnnee>
     */
    #[ORM\OneToMany(targetEntity: NoteAnnee::class, mappedBy: 'etudiant')]
    private Collection $noteAnnees;

    /**
     * @var Collection<int, NoteDivision>
     */
    #[ORM\OneToMany(targetEntity: NoteDivision::class, mappedBy: 'etudiant')]
    private Collection $noteDivisions;

    /**
     * @var Collection<int, NoteGroupe>
     */
    #[ORM\OneToMany(targetEntity: NoteGroupe::class, mappedBy: 'etudiant')]
    private Collection $noteGroupes;

    /**
     * @var Collection<int, NoteUe>
     */
    #[ORM\OneToMany(targetEntity: NoteUe::class, mappedBy: 'etudiant')]
    private Collection $noteUes;

    /**
     * @var Collection<int, NoteEpreuve>
     */
    #[ORM\OneToMany(targetEntity: NoteEpreuve::class, mappedBy: 'etudiant')]
    private Collection $noteEpreuves;

    public function __construct()
    {
        $this->noteAnnees = new ArrayCollection();
        $this->noteDivisions = new ArrayCollection();
        $this->noteGroupes = new ArrayCollection();
        $this->noteUes = new ArrayCollection();
        $this->noteEpreuves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

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

    /**
     * @return Collection<int, NoteAnnee>
     */
    public function getNoteAnnees(): Collection
    {
        return $this->noteAnnees;
    }

    public function addNoteAnnee(NoteAnnee $noteAnnee): static
    {
        if (!$this->noteAnnees->contains($noteAnnee)) {
            $this->noteAnnees->add($noteAnnee);
            $noteAnnee->setEtudiant($this);
        }

        return $this;
    }

    public function removeNoteAnnee(NoteAnnee $noteAnnee): static
    {
        if ($this->noteAnnees->removeElement($noteAnnee)) {
            // set the owning side to null (unless already changed)
            if ($noteAnnee->getEtudiant() === $this) {
                $noteAnnee->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NoteDivision>
     */
    public function getNoteDivisions(): Collection
    {
        return $this->noteDivisions;
    }

    public function addNoteDivision(NoteDivision $noteDivision): static
    {
        if (!$this->noteDivisions->contains($noteDivision)) {
            $this->noteDivisions->add($noteDivision);
            $noteDivision->setEtudiant($this);
        }

        return $this;
    }

    public function removeNoteDivision(NoteDivision $noteDivision): static
    {
        if ($this->noteDivisions->removeElement($noteDivision)) {
            // set the owning side to null (unless already changed)
            if ($noteDivision->getEtudiant() === $this) {
                $noteDivision->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NoteGroupe>
     */
    public function getNoteGroupes(): Collection
    {
        return $this->noteGroupes;
    }

    public function addNoteGroupe(NoteGroupe $noteGroupe): static
    {
        if (!$this->noteGroupes->contains($noteGroupe)) {
            $this->noteGroupes->add($noteGroupe);
            $noteGroupe->setEtudiant($this);
        }

        return $this;
    }

    public function removeNoteGroupe(NoteGroupe $noteGroupe): static
    {
        if ($this->noteGroupes->removeElement($noteGroupe)) {
            // set the owning side to null (unless already changed)
            if ($noteGroupe->getEtudiant() === $this) {
                $noteGroupe->setEtudiant(null);
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
            $noteUe->setEtudiant($this);
        }

        return $this;
    }

    public function removeNoteUe(NoteUe $noteUe): static
    {
        if ($this->noteUes->removeElement($noteUe)) {
            // set the owning side to null (unless already changed)
            if ($noteUe->getEtudiant() === $this) {
                $noteUe->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NoteEpreuve>
     */
    public function getNoteEpreuves(): Collection
    {
        return $this->noteEpreuves;
    }

    public function addNoteEpreufe(NoteEpreuve $noteEpreufe): static
    {
        if (!$this->noteEpreuves->contains($noteEpreufe)) {
            $this->noteEpreuves->add($noteEpreufe);
            $noteEpreufe->setEtudiant($this);
        }

        return $this;
    }

    public function removeNoteEpreufe(NoteEpreuve $noteEpreufe): static
    {
        if ($this->noteEpreuves->removeElement($noteEpreufe)) {
            // set the owning side to null (unless already changed)
            if ($noteEpreufe->getEtudiant() === $this) {
                $noteEpreufe->setEtudiant(null);
            }
        }

        return $this;
    }
}
