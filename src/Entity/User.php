<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message:"email is required")]
    #[Assert\Email(message:"email must be valid")]

    private ?string $email = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message:"name is required")]
    private ?string $name=null;

    #[ORM\Column(length: 70)]
    #[Assert\NotBlank(message:"address is required")]

    private ?string $address=null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"role is required")]

    private array $roles = [];

    #[ORM\Column(length: 70)]

    private ?string $nomSociete=null;

    #[ORM\Column(length: 70)]

    private ?string $biographie=null;
    #[ORM\Column(length: 70)]

    private ?bool $emailVerified=null;


    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message:"contact is required")]
    #[Assert\Length(min: 8,minMessage: "Le numéro de téléphone doit comporter au moins {{ limit }} chiffres ")]

    private ?string  $contact=null;

    #[ORM\Column(length: 550)]

    private $reset_token;



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

    /**
     * @return bool|null
     */
    public function getEmailVerified(): ?bool
    {
        return $this->emailVerified;
    }

    /**
     * @param bool|null $emailVerified
     */
    public function setEmailVerified(?bool $emailVerified): void
    {
        $this->emailVerified = $emailVerified;
    }







    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }






    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }





    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message:"password is required")]

    private ?string $password = null;






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

    /**
     * @return string|null
     */
    public function getNomSociete(): ?string
    {
        return $this->nomSociete;
    }

    /**
     * @param string|null $nomSociete
     */
    public function setNomSociete(?string $nomSociete): void
    {
        $this->nomSociete = $nomSociete;
    }

    /**
     * @return string|null
     */
    public function getBiographie(): ?string
    {
        return $this->biographie;
    }

    /**
     * @param string|null $biographie
     */
    public function setBiographie(?string $biographie): void
    {
        $this->biographie = $biographie;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }


    public function getContact(): ?string
    {
        return $this->contact;
    }

    /**
     * @param string|null $contact
     */
    public function setContact(?string $contact): void
    {
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function getResetToken()
    {
        return $this->reset_token;
    }

    /**
     * @param mixed $reset_token
     */
    public function setResetToken($reset_token): void
    {
        $this->reset_token = $reset_token;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getListeAnnonce(): ArrayCollection|Collection
    {
        return $this->listeAnnonce;
    }

    /**
     * @param ArrayCollection|Collection $listeAnnonce
     */
    public function setListeAnnonce(ArrayCollection|Collection $listeAnnonce): void
    {
        $this->listeAnnonce = $listeAnnonce;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getListeQuiz(): ArrayCollection|Collection
    {
        return $this->listeQuiz;
    }

    /**
     * @param ArrayCollection|Collection $listeQuiz
     */
    public function setListeQuiz(ArrayCollection|Collection $listeQuiz): void
    {
        $this->listeQuiz = $listeQuiz;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getListeReclamation(): ArrayCollection|Collection
    {
        return $this->listeReclamation;
    }

    /**
     * @param ArrayCollection|Collection $listeReclamation
     */
    public function setListeReclamation(ArrayCollection|Collection $listeReclamation): void
    {
        $this->listeReclamation = $listeReclamation;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getListeRendezVous(): ArrayCollection|Collection
    {
        return $this->listeRendezVous;
    }

    /**
     * @param ArrayCollection|Collection $listeRendezVous
     */
    public function setListeRendezVous(ArrayCollection|Collection $listeRendezVous): void
    {
        $this->listeRendezVous = $listeRendezVous;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getListeNotification(): ArrayCollection|Collection
    {
        return $this->listeNotification;
    }

    /**
     * @param ArrayCollection|Collection $listeNotification
     */
    public function setListeNotification(ArrayCollection|Collection $listeNotification): void
    {
        $this->listeNotification = $listeNotification;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file): void
    {
        $this->file = $file;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getListeCandidature(): ArrayCollection|Collection
    {
        return $this->listeCandidature;
    }

    /**
     * @param ArrayCollection|Collection $listeCandidature
     */
    public function setListeCandidature(ArrayCollection|Collection $listeCandidature): void
    {
        $this->listeCandidature = $listeCandidature;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getListePostulationInUser(): ArrayCollection|Collection
    {
        return $this->listePostulationInUser;
    }

    /**
     * @param ArrayCollection|Collection $listePostulationInUser
     */
    public function setListePostulationInUser(ArrayCollection|Collection $listePostulationInUser): void
    {
        $this->listePostulationInUser = $listePostulationInUser;
    }




    public function getId(): ?int
    {
        return $this->id;
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


    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isEmailVerified(): ?bool
    {
        return $this->emailVerified;
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

}
