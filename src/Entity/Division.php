<?php

namespace App\Entity;

use App\Repository\DivisionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DivisionRepository::class)]
class Division
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $num = null;

    #[ORM\Column(length: 20)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $moyenneValidation = null;

    #[ORM\Column(nullable: true)]
    private ?float $moyenneMinimal = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarque = null;

    #[ORM\ManyToOne(inversedBy: 'divisions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Annee $annee = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupe $groupe = null;

    /**
     * @var Collection<int, NoteDivision>
     */
    #[ORM\OneToMany(targetEntity: NoteDivision::class, mappedBy: 'division')]
    private Collection $noteDivisions;

    public function __construct()
    {
        $this->noteDivisions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): static
    {
        $this->num = $num;

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

    public function getMoyenneValidation(): ?float
    {
        return $this->moyenneValidation;
    }

    public function setMoyenneValidation(float $moyenneValidation): static
    {
        $this->moyenneValidation = $moyenneValidation;

        return $this;
    }

    public function getMoyenneMinimal(): ?float
    {
        return $this->moyenneMinimal;
    }

    public function setMoyenneMinimal(?float $moyenneMinimal): static
    {
        $this->moyenneMinimal = $moyenneMinimal;

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

    public function getAnnee(): ?Annee
    {
        return $this->annee;
    }

    public function setAnnee(?Annee $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(Groupe $groupe): static
    {
        $this->groupe = $groupe;

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
            $noteDivision->setDivision($this);
        }

        return $this;
    }

    public function removeNoteDivision(NoteDivision $noteDivision): static
    {
        if ($this->noteDivisions->removeElement($noteDivision)) {
            // set the owning side to null (unless already changed)
            if ($noteDivision->getDivision() === $this) {
                $noteDivision->setDivision(null);
            }
        }

        return $this;
    }
}
