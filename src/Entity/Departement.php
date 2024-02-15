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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $responsable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adjoint = null;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: Fidel::class)]
    private Collection $fidels;

    #[ORM\Column(nullable: true)]
    private ?bool $supprimer = null;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: Responsable::class)]
    private Collection $responsables;

    public function __construct()
    {
        $this->sousDepartements = new ArrayCollection();
        $this->fidels = new ArrayCollection();
        $this->responsables = new ArrayCollection();
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

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(?string $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getAdjoint(): ?string
    {
        return $this->adjoint;
    }

    public function setAdjoint(?string $adjoint): static
    {
        $this->adjoint = $adjoint;

        return $this;
    }

    /**
     * @return Collection<int, Fidel>
     */
    public function getFidels(): Collection
    {
        return $this->fidels;
    }

    public function addFidel(Fidel $fidel): static
    {
        if (!$this->fidels->contains($fidel)) {
            $this->fidels->add($fidel);
            $fidel->setDepartement($this);
        }

        return $this;
    }

    public function removeFidel(Fidel $fidel): static
    {
        if ($this->fidels->removeElement($fidel)) {
            // set the owning side to null (unless already changed)
            if ($fidel->getDepartement() === $this) {
                $fidel->setDepartement(null);
            }
        }

        return $this;
    }

    public function isSupprimer(): ?bool
    {
        return $this->supprimer;
    }

    public function setSupprimer(?bool $supprimer): static
    {
        $this->supprimer = $supprimer;

        return $this;
    }

    /**
     * @return Collection<int, Responsable>
     */
    public function getResponsables(): Collection
    {
        return $this->responsables;
    }

    public function addResponsable(Responsable $responsable): static
    {
        if (!$this->responsables->contains($responsable)) {
            $this->responsables->add($responsable);
            $responsable->setDepartement($this);
        }

        return $this;
    }

    public function removeResponsable(Responsable $responsable): static
    {
        if ($this->responsables->removeElement($responsable)) {
            // set the owning side to null (unless already changed)
            if ($responsable->getDepartement() === $this) {
                $responsable->setDepartement(null);
            }
        }

        return $this;
    }
}
