<?php

namespace App\Entity;

use App\Repository\TypeCulteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeCulteRepository::class)]
class TypeCulte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'typeCulte', targetEntity: Culte::class)]
    private Collection $cultes;

    public function __construct()
    {
        $this->cultes = new ArrayCollection();
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

    /**
     * @return Collection<int, Culte>
     */
    public function getCultes(): Collection
    {
        return $this->cultes;
    }

    public function addCulte(Culte $culte): static
    {
        if (!$this->cultes->contains($culte)) {
            $this->cultes->add($culte);
            $culte->setTypeCulte($this);
        }

        return $this;
    }

    public function removeCulte(Culte $culte): static
    {
        if ($this->cultes->removeElement($culte)) {
            // set the owning side to null (unless already changed)
            if ($culte->getTypeCulte() === $this) {
                $culte->setTypeCulte(null);
            }
        }

        return $this;
    }
}
