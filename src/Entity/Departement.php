<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: SousDepartement::class)]
    private Collection $sousDepartements;

    public function __construct()
    {
        $this->sousDepartements = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, SousDepartement>
     */
    public function getSousDepartements(): Collection
    {
        return $this->sousDepartements;
    }

    public function addSousDepartement(SousDepartement $sousDepartement): static
    {
        if (!$this->sousDepartements->contains($sousDepartement)) {
            $this->sousDepartements->add($sousDepartement);
            $sousDepartement->setDepartement($this);
        }

        return $this;
    }

    public function removeSousDepartement(SousDepartement $sousDepartement): static
    {
        if ($this->sousDepartements->removeElement($sousDepartement)) {
            // set the owning side to null (unless already changed)
            if ($sousDepartement->getDepartement() === $this) {
                $sousDepartement->setDepartement(null);
            }
        }

        return $this;
    }
}
