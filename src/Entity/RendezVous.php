<?php

namespace App\Entity;
use App\Repository\RendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]

class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $idRendezVous;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateRendezVous = null;

    #[ORM\Column(length:30 )]
    private ?string $heureRendezVous = null;


    #[ORM\ManyToOne(inversedBy:'listeRendezVous' )]

    #[ORM\JoinColumn(name: 'id_annonce', referencedColumnName: 'id_annonce')]

    private ?Annonce $annonceAssocierRendezVous;



    #[ORM\ManyToOne(inversedBy:'listeRendezVous' )]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id')]

    private ?Utilisateur $userRendezVous;

    public function getIdRendezVous(): ?string
    {
        return $this->idRendezVous;
    }

    public function getDateRendezVous(): ?\DateTimeInterface
    {
        return $this->dateRendezVous;
    }

    public function setDateRendezVous(\DateTimeInterface $dateRendezVous): self
    {
        $this->dateRendezVous = $dateRendezVous;

        return $this;
    }

    public function getHeureRendezVous(): ?string
    {
        return $this->heureRendezVous;
    }

    public function setHeureRendezVous(string $heureRendezVous): self
    {
        $this->heureRendezVous = $heureRendezVous;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    public function getUserRendezVous(): ?Utilisateur
    {
        return $this->userRendezVous;
    }

    public function setUserRendezVous(?Utilisateur $userRendezVous): self
    {
        $this->userRendezVous = $userRendezVous;

        return $this;
    }

    public function getAnnonceAssocierRendezVous(): ?Annonce
    {
        return $this->annonceAssocierRendezVous;
    }

    public function setAnnonceAssocierRendezVous(?Annonce $annonceAssocierRendezVous): self
    {
        $this->annonceAssocierRendezVous = $annonceAssocierRendezVous;

        return $this;
    }



}
