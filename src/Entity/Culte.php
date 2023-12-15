<?php

namespace App\Entity;

use App\Repository\CulteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CulteRepository::class)]
class Culte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateculte = null;

    #[ORM\Column]
    private ?int $effectif = null;

    #[ORM\Column(nullable: true)]
    private ?int $nouveauVenu = null;

    #[ORM\ManyToOne(inversedBy: 'cultes')]
    private ?TypeCulte $typeCulte = null;

    #[ORM\OneToMany(mappedBy: 'culte', targetEntity: Offrande::class)]
    private Collection $offrandes;

    public function __construct()
    {
        $this->offrandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): static
    {
        $this->libelle = $libelle;

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

    public function getDateculte(): ?\DateTimeInterface
    {
        return $this->dateculte;
    }

    public function setDateculte(\DateTimeInterface $dateculte): static
    {
        $this->dateculte = $dateculte;

        return $this;
    }

    public function getEffectif(): ?int
    {
        return $this->effectif;
    }

    public function setEffectif(int $effectif): static
    {
        $this->effectif = $effectif;

        return $this;
    }

    public function getNouveauVenu(): ?int
    {
        return $this->nouveauVenu;
    }

    public function setNouveauVenu(?int $nouveauVenu): static
    {
        $this->nouveauVenu = $nouveauVenu;

        return $this;
    }

    public function getTypeCulte(): ?TypeCulte
    {
        return $this->typeCulte;
    }

    public function setTypeCulte(?TypeCulte $typeCulte): static
    {
        $this->typeCulte = $typeCulte;

        return $this;
    }

    /**
     * @return Collection<int, Offrande>
     */
    public function getOffrandes(): Collection
    {
        return $this->offrandes;
    }

    public function addOffrande(Offrande $offrande): static
    {
        if (!$this->offrandes->contains($offrande)) {
            $this->offrandes->add($offrande);
            $offrande->setCulte($this);
        }

        return $this;
    }

    public function removeOffrande(Offrande $offrande): static
    {
        if ($this->offrandes->removeElement($offrande)) {
            // set the owning side to null (unless already changed)
            if ($offrande->getCulte() === $this) {
                $offrande->setCulte(null);
            }
        }

        return $this;
    }
}
