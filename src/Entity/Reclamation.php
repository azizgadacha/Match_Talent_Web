<?php

namespace App\Entity;
use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]

class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int  $idReclamation=null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;


    #[ORM\Column(length: 50)]
    private ?string $titre = null;



    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;



    #[ORM\Column(length: 255)]
    private ?string $statut = null;


    #[ORM\ManyToOne(inversedBy:'listeReclamation' )]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id')]

    private ?Utilisateur $userReclamation;

    #[ORM\OneToOne(mappedBy:'reclamation' ,cascade:['persist','remove'])]
    private ?ReponseReclamation $reponseReclamation=null;

    public function getIdReclamation(): ?int
    {
        return $this->idReclamation;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getUserReclamation(): ?Utilisateur
    {
        return $this->userReclamation;
    }

    public function setUserReclamation(?Utilisateur $userReclamation): self
    {
        $this->userReclamation = $userReclamation;

        return $this;
    }

    public function getReponseReclamation(): ?ReponseReclamation
    {
        return $this->reponseReclamation;
    }

    public function setReponseReclamation(?ReponseReclamation $reponseReclamation): self
    {
        // unset the owning side of the relation if necessary
        if ($reponseReclamation === null && $this->reponseReclamation !== null) {
            $this->reponseReclamation->setReclamation(null);
        }

        // set the owning side of the relation if necessary
        if ($reponseReclamation !== null && $reponseReclamation->getReclamation() !== $this) {
            $reponseReclamation->setReclamation($this);
        }

        $this->reponseReclamation = $reponseReclamation;

        return $this;
    }


}
