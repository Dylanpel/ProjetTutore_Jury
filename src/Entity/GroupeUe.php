<?php

namespace App\Entity;

use App\Repository\GroupeUeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupeUeRepository::class)]
class GroupeUe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarque = null;

    #[ORM\ManyToOne(inversedBy: 'groupeUes')]
    #[ORM\JoinColumn(name: 'id_groupe', nullable: false)]
    private ?Groupe $groupe = null;

    #[ORM\ManyToOne(inversedBy: 'groupeUes')]
    #[ORM\JoinColumn(name: 'id_ue', nullable: false)]
    private ?Ue $ue = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): static
    {
        $this->groupe = $groupe;

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
