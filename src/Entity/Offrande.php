<?php

namespace App\Entity;

use App\Repository\OffrandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffrandeRepository::class)]
class Offrande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $montantFC = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $montantUSD = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $montantEUR = null;

    #[ORM\ManyToOne(inversedBy: 'offrandes')]
    private ?TypeOffrande $typeOffrande = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'offrandes')]
    private ?Culte $culte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getMontantFC(): ?string
    {
        return $this->montantFC;
    }

    public function setMontantFC(string $montantFC): static
    {
        $this->montantFC = $montantFC;

        return $this;
    }

    public function getMontantUSD(): ?string
    {
        return $this->montantUSD;
    }

    public function setMontantUSD(string $montantUSD): static
    {
        $this->montantUSD = $montantUSD;

        return $this;
    }

    public function getMontantEUR(): ?string
    {
        return $this->montantEUR;
    }

    public function setMontantEUR(?string $montantEUR): static
    {
        $this->montantEUR = $montantEUR;

        return $this;
    }

    public function getTypeOffrande(): ?TypeOffrande
    {
        return $this->typeOffrande;
    }

    public function setTypeOffrande(?TypeOffrande $typeOffrande): static
    {
        $this->typeOffrande = $typeOffrande;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCulte(): ?Culte
    {
        return $this->culte;
    }

    public function setCulte(?Culte $culte): static
    {
        $this->culte = $culte;

        return $this;
    }
}
