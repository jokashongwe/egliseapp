<?php

namespace App\Entity;

use App\Repository\TypeOffrandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeOffrandeRepository::class)]
class TypeOffrande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'typeOffrande', targetEntity: Offrande::class)]
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

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

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
            $offrande->setTypeOffrande($this);
        }

        return $this;
    }

    public function removeOffrande(Offrande $offrande): static
    {
        if ($this->offrandes->removeElement($offrande)) {
            // set the owning side to null (unless already changed)
            if ($offrande->getTypeOffrande() === $this) {
                $offrande->setTypeOffrande(null);
            }
        }

        return $this;
    }
}
