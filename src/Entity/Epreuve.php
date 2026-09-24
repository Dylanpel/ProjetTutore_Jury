<?php

namespace App\Entity;

use App\Repository\EpreuveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpreuveRepository::class)]
class Epreuve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $coefficient = null;

    #[ORM\Column(nullable: true)]
    private ?float $moyenneMinimale = null;

    #[ORM\Column(nullable: true)]
    private ?int $duree = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarque = null;

    #[ORM\ManyToOne(inversedBy: 'epreuves')]
    #[ORM\JoinColumn(name: 'id_ue', nullable: false)]
    private ?Ue $ue = null;

    #[ORM\ManyToOne(inversedBy: 'epreuves')]
    #[ORM\JoinColumn(name: 'id_nature', nullable: false)]
    private ?Nature $nature = null;

    /**
     * @var Collection<int, NoteEpreuve>
     */
    #[ORM\OneToMany(targetEntity: NoteEpreuve::class, mappedBy: 'eprueve')]
    private Collection $noteEpreuves;

    public function __construct()
    {
        $this->noteEpreuves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
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

    public function getCoefficient(): ?float
    {
        return $this->coefficient;
    }

    public function setCoefficient(float $coefficient): static
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    public function getMoyenneMinimale(): ?float
    {
        return $this->moyenneMinimale;
    }

    public function setMoyenneMinimale(?float $moyenneMinimale): static
    {
        $this->moyenneMinimale = $moyenneMinimale;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): static
    {
        $this->duree = $duree;

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

    public function getUe(): ?Ue
    {
        return $this->ue;
    }

    public function setUe(?Ue $ue): static
    {
        $this->ue = $ue;

        return $this;
    }

    public function getNature(): ?Nature
    {
        return $this->nature;
    }

    public function setNature(?Nature $nature): static
    {
        $this->nature = $nature;

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
            $noteEpreufe->setEprueve($this);
        }

        return $this;
    }

    public function removeNoteEpreufe(NoteEpreuve $noteEpreufe): static
    {
        if ($this->noteEpreuves->removeElement($noteEpreufe)) {
            // set the owning side to null (unless already changed)
            if ($noteEpreufe->getEprueve() === $this) {
                $noteEpreufe->setEprueve(null);
            }
        }

        return $this;
    }
}
