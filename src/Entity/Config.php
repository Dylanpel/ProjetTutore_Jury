<?php

namespace App\Entity;

use App\Repository\ConfigRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigRepository::class)]
class Config
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $annee = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $responsable = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $webmaster = null;

    #[ORM\Column]
    private ?bool $is_actif = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarque = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(?string $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getWebmaster(): ?string
    {
        return $this->webmaster;
    }

    public function setWebmaster(?string $webmaster): static
    {
        $this->webmaster = $webmaster;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->is_actif;
    }

    public function setIsActif(bool $is_actif): static
    {
        $this->is_actif = $is_actif;

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
}
