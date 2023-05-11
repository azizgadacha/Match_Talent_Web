<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]

class Utilisateur
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue ]
    #[Groups(['off','postulation'])]
    private ?int $id=null;

    #[ORM\Column(length: 70)]

    private ?int $nomSociete=null;

    #[ORM\Column(length: 70)]

    private ?string $biographie=null;

    #[ORM\Column(length: 50)]

    private ?string $username=null;

    #[ORM\Column(length: 70)]

    private ?string $address=null;

    #[ORM\Column(length: 50)]

    private ?string $motDePasse=null;

    #[ORM\Column(length: 70)]

    private ?string $email=null;

    #[ORM\Column(length: 50)]

    private ?string  $contact=null;



    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Annonce::class, orphanRemoval: true)]
    private Collection $listeAnnonce;

    #[ORM\OneToMany(mappedBy: 'userQuiz', targetEntity: Quiz::class, orphanRemoval: true)]
    private Collection $listeQuiz;
    #[ORM\OneToMany(mappedBy: 'userReclamation', targetEntity: Reclamation::class, orphanRemoval: true)]
    private Collection $listeReclamation;

    #[ORM\OneToMany(mappedBy: 'userRendezVous', targetEntity: RendezVous::class, orphanRemoval: true)]
    private Collection $listeRendezVous;
    #[ORM\OneToMany(mappedBy: 'userNotification', targetEntity: Notification::class, orphanRemoval: true)]
    private Collection $listeNotification;
    #[ORM\OneToOne(mappedBy:'userFile' ,cascade:['persist','remove'])]
    private ?File $file=null;
    #[ORM\OneToMany(mappedBy: 'utilisateurAssocier', targetEntity: Candidature::class, orphanRemoval: true)]
    private Collection $listeCandidature;
    #[ORM\OneToMany(mappedBy: 'userPostulation', targetEntity: Postulation::class, orphanRemoval: true)]
    private Collection $listePostulationInUser;


    #[ORM\ManyToOne(inversedBy:'userListe' )]
    #[ORM\JoinColumn(name:'id_role', referencedColumnName:'id_role')]
    private ?Role  $roleUser;

    public function __construct()
    {
        $this->listeAnnonce = new ArrayCollection();
        $this->listeQuiz = new ArrayCollection();
        $this->listeReclamation = new ArrayCollection();
        $this->listeRendezVous = new ArrayCollection();
        $this->listeNotification = new ArrayCollection();
        $this->listeCandidature = new ArrayCollection();
        $this->listePostulationInUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSociete(): ?int
    {
        return $this->nomSociete;
    }

    public function setNomSociete(int $nomSociete): self
    {
        $this->nomSociete = $nomSociete;

        return $this;
    }

    public function getBiographie(): ?string
    {
        return $this->biographie;
    }

    public function setBiographie(string $biographie): self
    {
        $this->biographie = $biographie;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }



    /**
     * @return Collection<int, Annonce>
     */
    public function getListeAnnonce(): Collection
    {
        return $this->listeAnnonce;
    }

    public function addListeAnnonce(Annonce $listeAnnonce): self
    {
        if (!$this->listeAnnonce->contains($listeAnnonce)) {
            $this->listeAnnonce->add($listeAnnonce);
            $listeAnnonce->setUtilisateur($this);
        }

        return $this;
    }

    public function removeListeAnnonce(Annonce $listeAnnonce): self
    {
        if ($this->listeAnnonce->removeElement($listeAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($listeAnnonce->getUtilisateur() === $this) {
                $listeAnnonce->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Quiz>
     */
    public function getListeQuiz(): Collection
    {
        return $this->listeQuiz;
    }

    public function addListeQuiz(Quiz $listeQuiz): self
    {
        if (!$this->listeQuiz->contains($listeQuiz)) {
            $this->listeQuiz->add($listeQuiz);
            $listeQuiz->setUserQuiz($this);
        }

        return $this;
    }

    public function removeListeQuiz(Quiz $listeQuiz): self
    {
        if ($this->listeQuiz->removeElement($listeQuiz)) {
            // set the owning side to null (unless already changed)
            if ($listeQuiz->getUserQuiz() === $this) {
                $listeQuiz->setUserQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reclamation>
     */
    public function getListeReclamation(): Collection
    {
        return $this->listeReclamation;
    }

    public function addListeReclamation(Reclamation $listeReclamation): self
    {
        if (!$this->listeReclamation->contains($listeReclamation)) {
            $this->listeReclamation->add($listeReclamation);
            $listeReclamation->setUserReclamation($this);
        }

        return $this;
    }

    public function removeListeReclamation(Reclamation $listeReclamation): self
    {
        if ($this->listeReclamation->removeElement($listeReclamation)) {
            // set the owning side to null (unless already changed)
            if ($listeReclamation->getUserReclamation() === $this) {
                $listeReclamation->setUserReclamation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getListeRendezVous(): Collection
    {
        return $this->listeRendezVous;
    }

    public function addListeRendezVou(RendezVous $listeRendezVou): self
    {
        if (!$this->listeRendezVous->contains($listeRendezVou)) {
            $this->listeRendezVous->add($listeRendezVou);
            $listeRendezVou->setUserRendezVous($this);
        }

        return $this;
    }

    public function removeListeRendezVou(RendezVous $listeRendezVou): self
    {
        if ($this->listeRendezVous->removeElement($listeRendezVou)) {
            // set the owning side to null (unless already changed)
            if ($listeRendezVou->getUserRendezVous() === $this) {
                $listeRendezVou->setUserRendezVous(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getListeNotification(): Collection
    {
        return $this->listeNotification;
    }

    public function addListeNotification(Notification $listeNotification): self
    {
        if (!$this->listeNotification->contains($listeNotification)) {
            $this->listeNotification->add($listeNotification);
            $listeNotification->setUserNotification($this);
        }

        return $this;
    }

    public function removeListeNotification(Notification $listeNotification): self
    {
        if ($this->listeNotification->removeElement($listeNotification)) {
            // set the owning side to null (unless already changed)
            if ($listeNotification->getUserNotification() === $this) {
                $listeNotification->setUserNotification(null);
            }
        }

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): self
    {
        // unset the owning side of the relation if necessary
        if ($file === null && $this->file !== null) {
            $this->file->setUserFile(null);
        }

        // set the owning side of the relation if necessary
        if ($file !== null && $file->getUserFile() !== $this) {
            $file->setUserFile($this);
        }

        $this->file = $file;

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
            $listeCandidature->setUtilisateurAssocier($this);
        }

        return $this;
    }

    public function removeListeCandidature(Candidature $listeCandidature): self
    {
        if ($this->listeCandidature->removeElement($listeCandidature)) {
            // set the owning side to null (unless already changed)
            if ($listeCandidature->getUtilisateurAssocier() === $this) {
                $listeCandidature->setUtilisateurAssocier(null);
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
            $listePostulationInUser->setUserPostulation($this);
        }

        return $this;
    }

    public function removeListePostulationInUser(Postulation $listePostulationInUser): self
    {
        if ($this->listePostulationInUser->removeElement($listePostulationInUser)) {
            // set the owning side to null (unless already changed)
            if ($listePostulationInUser->getUserPostulation() === $this) {
                $listePostulationInUser->setUserPostulation(null);
            }
        }

        return $this;
    }

    public function getRoleUser(): ?Role
    {
        return $this->roleUser;
    }

    public function setRoleUser(?Role $roleUser): self
    {
        $this->roleUser = $roleUser;

        return $this;
    }
}














