<?php

namespace App\Entity;

use App\Repository\SousDepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousDepartementRepository::class)]
class SousDepartement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'sousDepartements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Departement $departement = null;

    #[ORM\OneToMany(mappedBy: 'sousdepartement', targetEntity: Fidel::class)]
    private Collection $fidels;
    //departement
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $responsable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adjoint = null;

    #[ORM\Column(nullable: true)]
    private ?bool $supprimer = null;

    public function __construct()
    {
        $this->fidels = new ArrayCollection();
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

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;

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
            $fidel->setSousdepartement($this);
        }

        return $this;
    }

    public function removeFidel(Fidel $fidel): static
    {
        if ($this->fidels->removeElement($fidel)) {
            // set the owning side to null (unless already changed)
            if ($fidel->getSousdepartement() === $this) {
                $fidel->setSousdepartement(null);
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

    public function isSupprimer(): ?bool
    {
        return $this->supprimer;
    }

    public function setSupprimer(?bool $supprimer): static
    {
        $this->supprimer = $supprimer;

        return $this;
    }
}
