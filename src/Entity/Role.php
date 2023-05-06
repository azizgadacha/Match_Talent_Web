<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{

    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private ?int $idRole = null;

    #[ORM\Column(length: 50)]
    private ?string $nomRole=null;

    #[ORM\Column(length: 50)]
    private ?string $description=null;

    #[ORM\OneToMany(mappedBy: 'roleUser', targetEntity: User::class, orphanRemoval: true)]
    private Collection $userListe;



    public function __construct()
    {
        $this->userListe = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
    }

    public function getIdRole(): ?int
    {
        return $this->idRole;
    }

    public function getNomRole(): ?string
    {
        return $this->nomRole;
    }

    public function setNomRole(string $nomRole): self
    {
        $this->nomRole = $nomRole;

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

    /**
     * @return Collection<int, User>
     */
    public function getUserListe(): Collection
    {
        return $this->userListe;
    }

    public function addUserListe(User $userListe): self
    {
        if (!$this->userListe->contains($userListe)) {
            $this->userListe->add($userListe);
            $userListe->setRole($this);
        }

        return $this;
    }

    public function removeUserListe(User $userListe): self
    {
        if ($this->userListe->removeElement($userListe)) {
            // set the owning side to null (unless already changed)
            if ($userListe->getRole() === $this) {
                $userListe->setRole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(User $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->setRole($this);
        }

        return $this;
    }

    public function removeUtilisateur(User $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getRole() === $this) {
                $utilisateur->setRole(null);
            }
        }

        return $this;
    }

}
