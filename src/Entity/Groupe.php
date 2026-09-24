<?php

namespace App\Entity;

use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupeRepository::class)]
class Groupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?float $ects = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    private ?float $moyenneMinimale = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarque = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'enfants')]
    #[ORM\JoinColumn(name: 'id_parent')]
    private ?self $parent = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    private Collection $enfants;

    /**
     * @var Collection<int, GroupeUe>
     */
    #[ORM\OneToMany(targetEntity: GroupeUe::class, mappedBy: 'groupe')]
    private Collection $groupeUes;

    /**
     * @var Collection<int, NoteGroupe>
     */
    #[ORM\OneToMany(targetEntity: NoteGroupe::class, mappedBy: 'groupe')]
    private Collection $noteGroupes;

    public function __construct()
    {
        $this->enfants = new ArrayCollection();
        $this->groupeUes = new ArrayCollection();
        $this->noteGroupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getEcts(): ?float
    {
        return $this->ects;
    }

    public function setEcts(?float $ects): static
    {
        $this->ects = $ects;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

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

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): static
    {
        $this->remarque = $remarque;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getEnfants(): Collection
    {
        return $this->enfants;
    }

    public function addEnfant(self $enfant): static
    {
        if (!$this->enfants->contains($enfant)) {
            $this->enfants->add($enfant);
            $enfant->setParent($this);
        }

        return $this;
    }

    public function removeEnfant(self $enfant): static
    {
        if ($this->enfants->removeElement($enfant)) {
            // set the owning side to null (unless already changed)
            if ($enfant->getParent() === $this) {
                $enfant->setParent(null);
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
            $groupeUe->setGroupe($this);
        }

        return $this;
    }

    public function removeGroupeUe(GroupeUe $groupeUe): static
    {
        if ($this->groupeUes->removeElement($groupeUe)) {
            // set the owning side to null (unless already changed)
            if ($groupeUe->getGroupe() === $this) {
                $groupeUe->setGroupe(null);
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
            $noteGroupe->setGroupe($this);
        }

        return $this;
    }

    public function removeNoteGroupe(NoteGroupe $noteGroupe): static
    {
        if ($this->noteGroupes->removeElement($noteGroupe)) {
            // set the owning side to null (unless already changed)
            if ($noteGroupe->getGroupe() === $this) {
                $noteGroupe->setGroupe(null);
            }
        }

        return $this;
    }
}
