<?php

namespace App\Entity;
use App\Repository\AnnonceRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;



#[ORM\Entity(repositoryClass: AnnonceRepository::class)]

class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("Annonce")]

    private ?int  $idAnnonce =null;


    
    #[ORM\Column(length: 50)]
    //#[Assert\NotBlank(message: "Le nom de le titre ne peut pas être vide.")]
    /*#[Assert\Length(
        max: 50,
        maxMessage: "Le titre ne peut pas contenir plus de {{ limit }} caractères."
    )]*/
    #[Assert\Length(min: 3, max: 50)]
    #[Groups("Annonce")]

    private ?string $titre = null;

    #[ORM\Column(length: 50)]
   // #[Assert\NotBlank]
    //#[Assert\Length(min: 3, max: 50)]
    #[Groups("Annonce")]

    private ?string $Societe = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
   // #[Assert\NotBlank]
    //#[Assert\Date]
    #[Groups("Annonce")]

    private ?\DateTimeInterface $datedebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    //#[Assert\NotBlank]
    //#[Assert\Date]
    #[Groups("Annonce")]

    private ?\DateTimeInterface $datefin = null;

    #[ORM\Column(length: 50)]
  //  #[Assert\NotBlank]
  //  #[Assert\Length(min: 3, max: 50)]
    #[Groups("Annonce")]

    private ?string $description = null;

    #[ORM\Column(length: 50)]
   // #[Assert\NotBlank]
   // #[Assert\Length(min: 3, max: 50)]
    #[Groups("Annonce")]

    private ?string $typeContrat = null;

    #[ORM\ManyToOne(inversedBy:'AnnoceAssocier' )]
    #[ORM\JoinColumn(name: 'id_quiz', referencedColumnName: 'id_quiz')]

    private ?Quiz $quiz;

    #[ORM\ManyToOne(inversedBy:'listeAnnonceInCategorie' )]
    #[ORM\JoinColumn(name: 'id_categorie', referencedColumnName: 'id_categorie')]

    private ?Categorie $categorieAnnonce=null;

    #[ORM\ManyToOne(inversedBy:'listeAnnonce' )]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id')]


    private ?User $utilisateur=null;
    #[Groups("Annonce")]

    #[ORM\OneToMany(mappedBy: 'annonceAssocier', targetEntity: Candidature::class, orphanRemoval: true)]


    private Collection $listeCandidatureInAnnonce;

    #[ORM\OneToMany(mappedBy: 'annoncePostulation', targetEntity: Postulation::class, orphanRemoval: true)]
    private Collection $listePostulationInAnnonce;

    #[ORM\OneToMany(mappedBy: 'annonceAssocierRendezVous', targetEntity: RendezVous::class, orphanRemoval: true)]
    private Collection $listeRendezVous;

    public function __construct()
    {
        $this->listeCandidature = new ArrayCollection();
        $this->listePostulationInUser = new ArrayCollection();
        $this->listeCandidatureInAnnonce = new ArrayCollection();
        $this->listePostulationInAnnonce = new ArrayCollection();
        $this->listeRendezVous = new ArrayCollection();
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

    public function getSociete(): ?string
    {
        return $this->Societe;
    }

    public function setSociete(string $Societe): self
    {
        $this->Societe = $Societe;

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

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
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

    /**
     * @return Collection
     */
    public function getListeCandidatureInAnnonce(): Collection
    {
        return $this->listeCandidatureInAnnonce;
    }

    /**
     * @param Collection $listeCandidatureInAnnonce
     */
    public function setListeCandidatureInAnnonce(Collection $listeCandidatureInAnnonce): void
    {
        $this->listeCandidatureInAnnonce = $listeCandidatureInAnnonce;
    }

    /**
     * @return Collection
     */
    public function getListePostulationInAnnonce(): Collection
    {
        return $this->listePostulationInAnnonce;
    }

    /**
     * @param Collection $listePostulationInAnnonce
     */
    public function setListePostulationInAnnonce(Collection $listePostulationInAnnonce): void
    {
        $this->listePostulationInAnnonce = $listePostulationInAnnonce;
    }

    /**
     * @return Collection
     */
    public function getListeRendezVous(): Collection
    {
        return $this->listeRendezVous;
    }

    /**
     * @param Collection $listeRendezVous
     */
    public function setListeRendezVous(Collection $listeRendezVous): void
    {
        $this->listeRendezVous = $listeRendezVous;
    }

    public function addListeCandidatureInAnnonce(Candidature $listeCandidatureInAnnonce): self
    {
        if (!$this->listeCandidatureInAnnonce->contains($listeCandidatureInAnnonce)) {
            $this->listeCandidatureInAnnonce->add($listeCandidatureInAnnonce);
            $listeCandidatureInAnnonce->setAnnonceAssocier($this);
        }

        return $this;
    }

    public function removeListeCandidatureInAnnonce(Candidature $listeCandidatureInAnnonce): self
    {
        if ($this->listeCandidatureInAnnonce->removeElement($listeCandidatureInAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($listeCandidatureInAnnonce->getAnnonceAssocier() === $this) {
                $listeCandidatureInAnnonce->setAnnonceAssocier(null);
            }
        }

        return $this;
    }

    public function addListePostulationInAnnonce(Postulation $listePostulationInAnnonce): self
    {
        if (!$this->listePostulationInAnnonce->contains($listePostulationInAnnonce)) {
            $this->listePostulationInAnnonce->add($listePostulationInAnnonce);
            $listePostulationInAnnonce->setAnnoncePostulation($this);
        }

        return $this;
    }

    public function removeListePostulationInAnnonce(Postulation $listePostulationInAnnonce): self
    {
        if ($this->listePostulationInAnnonce->removeElement($listePostulationInAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($listePostulationInAnnonce->getAnnoncePostulation() === $this) {
                $listePostulationInAnnonce->setAnnoncePostulation(null);
            }
        }

        return $this;
    }

    public function addListeRendezVou(RendezVous $listeRendezVou): self
    {
        if (!$this->listeRendezVous->contains($listeRendezVou)) {
            $this->listeRendezVous->add($listeRendezVou);
            $listeRendezVou->setAnnonceAssocierRendezVous($this);
        }

        return $this;
    }

    public function removeListeRendezVou(RendezVous $listeRendezVou): self
    {
        if ($this->listeRendezVous->removeElement($listeRendezVou)) {
            // set the owning side to null (unless already changed)
            if ($listeRendezVou->getAnnonceAssocierRendezVous() === $this) {
                $listeRendezVou->setAnnonceAssocierRendezVous(null);
            }
        }

        return $this;
    }



}
