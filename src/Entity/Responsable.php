<?php

namespace App\Entity;

use App\Repository\ResponsableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponsableRepository::class)]
class Responsable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'responsables')]
    private ?Fidel $fidel = null;

    #[ORM\ManyToOne(inversedBy: 'responsables')]
    private ?Departement $departement = null;

    #[ORM\ManyToOne(inversedBy: 'responsables')]
    private ?SousDepartement $sousdepartement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFidel(): ?Fidel
    {
        return $this->fidel;
    }

    public function setFidel(?Fidel $fidel): static
    {
        $this->fidel = $fidel;

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

    public function getSousdepartement(): ?Sousdepartement
    {
        return $this->sousdepartement;
    }

    public function setSousdepartement(?Sousdepartement $sousdepartement): static
    {
        $this->sousdepartement = $sousdepartement;

        return $this;
    }
}
