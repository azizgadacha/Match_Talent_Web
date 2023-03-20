<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]

class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCandidature=null;

    #[ORM\Column]
    private ?float $note = null;


    #[ORM\ManyToOne(inversedBy:'listeCandidature' )]
    private ?Annonce $annonceAssocier=null;

    #[ORM\ManyToOne(inversedBy:'listeCandidature' )]
    private ?Utilisateur $utilisateurAssocier=null;

    public function getIdCandidature(): ?int
    {
        return $this->idCandidature;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getAnnonceAssocier(): ?Annonce
    {
        return $this->annonceAssocier;
    }

    public function setAnnonceAssocier(?Annonce $annonceAssocier): self
    {
        $this->annonceAssocier = $annonceAssocier;

        return $this;
    }

    public function getUtilisateurAssocier(): ?Utilisateur
    {
        return $this->utilisateurAssocier;
    }

    public function setUtilisateurAssocier(?Utilisateur $utilisateurAssocier): self
    {
        $this->utilisateurAssocier = $utilisateurAssocier;

        return $this;
    }


}
