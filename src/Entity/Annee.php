<?php

namespace App\Entity;

use App\Repository\AnneeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnneeRepository::class)]
class Annee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $an = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $nomCourt = null;

    #[ORM\Column]
    private ?bool $isCompensable = null;

    #[ORM\Column]
    private ?float $moyenneValidation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarque = null;

    #[ORM\ManyToOne(inversedBy: 'annees')]
    #[ORM\JoinColumn(name: 'id_parcour', nullable: false)]
    private ?Parcour $parcour = null;

    /**
     * @var Collection<int, Division>
     */
    #[ORM\OneToMany(targetEntity: Division::class, mappedBy: 'annee')]
    private Collection $divisions;

    /**
     * @var Collection<int, AnneeUser>
     */
    #[ORM\OneToMany(targetEntity: AnneeUser::class, mappedBy: 'annee')]
    private Collection $anneeUsers;

    /**
     * @var Collection<int, NoteAnnee>
     */
    #[ORM\OneToMany(targetEntity: NoteAnnee::class, mappedBy: 'annee')]
    private Collection $noteAnnees;

    public function __construct()
    {
        $this->divisions = new ArrayCollection();
        $this->anneeUsers = new ArrayCollection();
        $this->noteAnnees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAn(): ?int
    {
        return $this->an;
    }

    public function setAn(int $an): static
    {
        $this->an = $an;

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

    public function getNomCourt(): ?string
    {
        return $this->nomCourt;
    }

    public function setNomCourt(?string $nomCourt): static
    {
        $this->nomCourt = $nomCourt;

        return $this;
    }

    public function isCompensable(): ?bool
    {
        return $this->isCompensable;
    }

    public function setIsCompensable(bool $isCompensable): static
    {
        $this->isCompensable = $isCompensable;

        return $this;
    }

    public function getMoyenneValidation(): ?float
    {
        return $this->moyenneValidation;
    }

    public function setMoyenneValidation(float $moyenneValidation): static
    {
        $this->moyenneValidation = $moyenneValidation;

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

    public function getParcour(): ?Parcour
    {
        return $this->parcour;
    }

    public function setParcour(?Parcour $parcour): static
    {
        $this->parcour = $parcour;

        return $this;
    }

    /**
     * @return Collection<int, Division>
     */
    public function getDivisions(): Collection
    {
        return $this->divisions;
    }

    public function addDivision(Division $division): static
    {
        if (!$this->divisions->contains($division)) {
            $this->divisions->add($division);
            $division->setAnnee($this);
        }

        return $this;
    }

    public function removeDivision(Division $division): static
    {
        if ($this->divisions->removeElement($division)) {
            // set the owning side to null (unless already changed)
            if ($division->getAnnee() === $this) {
                $division->setAnnee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AnneeUser>
     */
    public function getAnneeUsers(): Collection
    {
        return $this->anneeUsers;
    }

    public function addAnneeUser(AnneeUser $anneeUser): static
    {
        if (!$this->anneeUsers->contains($anneeUser)) {
            $this->anneeUsers->add($anneeUser);
            $anneeUser->setAnnee($this);
        }

        return $this;
    }

    public function removeAnneeUser(AnneeUser $anneeUser): static
    {
        if ($this->anneeUsers->removeElement($anneeUser)) {
            // set the owning side to null (unless already changed)
            if ($anneeUser->getAnnee() === $this) {
                $anneeUser->setAnnee(null);
            }
        }

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
            $noteAnnee->setAnnee($this);
        }

        return $this;
    }

    public function removeNoteAnnee(NoteAnnee $noteAnnee): static
    {
        if ($this->noteAnnees->removeElement($noteAnnee)) {
            // set the owning side to null (unless already changed)
            if ($noteAnnee->getAnnee() === $this) {
                $noteAnnee->setAnnee(null);
            }
        }

        return $this;
    }
}
