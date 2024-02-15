<?php

namespace App\Entity;

use App\Repository\FidelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FidelRepository::class)]
class Fidel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postnom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sexe = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profession = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_bapteme = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_conversion = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etatcivil = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numeroadresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avenue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $quartier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commune = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieunaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $province = null;

    #[ORM\Column(nullable: true)]
    private ?bool $supprimer = null;

    #[ORM\Column(nullable: true)]
    private ?bool $deces = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $idutilisateur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEnregistrement = null;

    #[ORM\ManyToOne(inversedBy: 'fidels')]
    private ?SousDepartement $sousdepartement = null;

    #[ORM\ManyToOne(inversedBy: 'fidels')]
    private ?Departement $departement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datemodif = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $modifIdUtilisateur = null;

    #[ORM\OneToMany(mappedBy: 'fidel', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'fidel', targetEntity: Responsable::class)]
    private Collection $responsables;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPostnom(): ?string
    {
        return $this->postnom;
    }

    public function setPostnom(?string $postnom): static
    {
        $this->postnom = $postnom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): static
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getDateBapteme(): ?\DateTimeInterface
    {
        return $this->date_bapteme;
    }

    public function setDateBapteme(?\DateTimeInterface $date_bapteme): static
    {
        $this->date_bapteme = $date_bapteme;


        return $this;
    }

    public function getDateConversion(): ?\DateTimeInterface
    {
        return $this->date_conversion;
    }

    public function setDateConversion(?\DateTimeInterface $date_conversion): static
    {
        $this->date_conversion = $date_conversion;

        return $this;
    }

    public function getNumeroPhone(): ?string
    {
        return $this->numero_phone;
    }

    public function setNumeroPhone(string $numero_phone): static
    {
        $this->numero_phone = $numero_phone;

        return $this;
    }

    public function getEtatcivil(): ?string
    {
        return $this->etatcivil;
    }

    public function setEtatcivil(?string $etatcivil): static
    {
        $this->etatcivil = $etatcivil;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): static
    {
        $this->observation = $observation;

        return $this;
    }

    public function getNumeroadresse(): ?string
    {
        return $this->numeroadresse;
    }

    public function setNumeroadresse(?string $numeroadresse): static
    {
        $this->numeroadresse = $numeroadresse;

        return $this;
    }

    public function getAvenue(): ?string
    {
        return $this->avenue;
    }

    public function setAvenue(?string $avenue): static
    {
        $this->avenue = $avenue;

        return $this;
    }

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(?string $quartier): static
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(?string $commune): static
    {
        $this->commune = $commune;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getLieunaissance(): ?string
    {
        return $this->lieunaissance;
    }

    public function setLieunaissance(?string $lieunaissance): static
    {
        $this->lieunaissance = $lieunaissance;

        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province): static
    {
        $this->province = $province;

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

    public function isDeces(): ?bool
    {
        return $this->deces;
    }

    public function setDeces(?bool $deces): static
    {
        $this->deces = $deces;

        return $this;
    }

    public function getIdutilisateur(): ?string
    {
        return $this->idutilisateur;
    }

    public function setIdutilisateur(string $idutilisateur): static
    {
        $this->idutilisateur = $idutilisateur;

        return $this;
    }

    public function getDateEnregistrement(): ?\DateTimeInterface
    {
        return $this->dateEnregistrement;
    }

    public function setDateEnregistrement(?\DateTimeInterface $dateEnregistrement): static
    {
        $this->dateEnregistrement = $dateEnregistrement;

        return $this;
    }

    public function getSousdepartement(): ?SousDepartement
    {
        return $this->sousdepartement;
    }

    public function setSousdepartement(?SousDepartement $sousdepartement): static
    {
        $this->sousdepartement = $sousdepartement;

        return $this;
    }

    public function getDepartement(): ?departement
    {
        return $this->departement;
    }

    public function setDepartement(?departement $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getDatemodif(): ?\DateTimeInterface
    {
        return $this->datemodif;
    }

    public function setDatemodif(?\DateTimeInterface $datemodif): static
    {
        $this->datemodif = $datemodif;

        return $this;
    }

    public function getModifIdUtilisateur(): ?string
    {
        return $this->modifIdUtilisateur;
    }

    public function setModifIdUtilisateur(?string $modifIdUtilisateur): static
    {
        $this->modifIdUtilisateur = $modifIdUtilisateur;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setFidel($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getFidel() === $this) {
                $user->setFidel(null);
            }
        }

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
            $responsable->setFidel($this);
        }

        return $this;
    }

    public function removeResponsable(Responsable $responsable): static
    {
        if ($this->responsables->removeElement($responsable)) {
            // set the owning side to null (unless already changed)
            if ($responsable->getFidel() === $this) {
                $responsable->setFidel(null);
            }
        }

        return $this;
    }
}
