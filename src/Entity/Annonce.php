<?php

namespace App\Entity;
use App\Repository\AnnonceRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]

class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int  $idAnnonce =null;

    #[ORM\Column(length: 50)]
    private ?string $titre = null;

    #[ORM\Column(length: 50)]
    private ?string $categorie = null;


    #[ORM\Column(length: 50)]

    private ?string $nomSocieté = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datedebut = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datefin = null;

    #[ORM\Column(length: 50)]

    private ?string $description = null;


    #[ORM\Column(length: 50)]
    private ?string $typeContrat = null;



    #[ORM\ManyToOne(inversedBy:'AnnoceAssocier' )]
    private ?Quiz $quiz=null;
    #[ORM\ManyToOne(inversedBy:'listeAnnonce' )]
    private ?Categorie $categorieAnnonce=null;

    //private $idQuiz;

    #[ORM\ManyToOne(inversedBy:'listeAnnonce' )]
    private ?Utilisateur $utilisateur=null;
    #[ORM\OneToMany(mappedBy: 'annonceAssocier', targetEntity: Candidature::class, orphanRemoval: true)]
    private Collection $listeCandidature;
    #[ORM\OneToMany(mappedBy: 'annoncePostulation', targetEntity: Postulation::class, orphanRemoval: true)]
    private Collection $listePostulationInUser;

    public function __construct()
    {
        $this->listeCandidature = new ArrayCollection();
        $this->listePostulationInUser = new ArrayCollection();
    }

    public function getIdAnnonce(): ?int
    {
        return $this->idAnnonce;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getNomSocieté(): ?string
    {
        return $this->nomSocieté;
    }

    public function setNomSocieté(string $nomSocieté): self
    {
        $this->nomSocieté = $nomSocieté;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTypeContrat(): ?string
    {
        return $this->typeContrat;
    }

    public function setTypeContrat(string $typeContrat): self
    {
        $this->typeContrat = $typeContrat;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getCategorieAnnonce(): ?Categorie
    {
        return $this->categorieAnnonce;
    }

    public function setCategorieAnnonce(?Categorie $categorieAnnonce): self
    {
        $this->categorieAnnonce = $categorieAnnonce;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Candidature>
     */
    public function getListeCandidature(): Collection
    {
        return $this->listeCandidature;
    }

    public function addListeCandidature(Candidature $listeCandidature): self
    {
        if (!$this->listeCandidature->contains($listeCandidature)) {
            $this->listeCandidature->add($listeCandidature);
            $listeCandidature->setAnnonceAssocier($this);
        }

        return $this;
    }

    public function removeListeCandidature(Candidature $listeCandidature): self
    {
        if ($this->listeCandidature->removeElement($listeCandidature)) {
            // set the owning side to null (unless already changed)
            if ($listeCandidature->getAnnonceAssocier() === $this) {
                $listeCandidature->setAnnonceAssocier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Postulation>
     */
    public function getListePostulationInUser(): Collection
    {
        return $this->listePostulationInUser;
    }

    public function addListePostulationInUser(Postulation $listePostulationInUser): self
    {
        if (!$this->listePostulationInUser->contains($listePostulationInUser)) {
            $this->listePostulationInUser->add($listePostulationInUser);
            $listePostulationInUser->setAnnoncePostulation($this);
        }

        return $this;
    }

    public function removeListePostulationInUser(Postulation $listePostulationInUser): self
    {
        if ($this->listePostulationInUser->removeElement($listePostulationInUser)) {
            // set the owning side to null (unless already changed)
            if ($listePostulationInUser->getAnnoncePostulation() === $this) {
                $listePostulationInUser->setAnnoncePostulation(null);
            }
        }

        return $this;
    }



}
