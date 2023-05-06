<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]

class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("Candiadature")]

    private ?int $idCandidature=null;

    #[ORM\Column]
    #[Groups("Candiadature")]

    private ?float $note = null;


    #[ORM\ManyToOne(inversedBy:'listeCandidatureInAnnonce' )]
    #[ORM\JoinColumn(name: 'id_annonce', referencedColumnName: 'id_annonce')]
    #[Groups("Candiadature")]

    private ?Annonce $annonceAssocier=null;

    #[ORM\ManyToOne(inversedBy:'listeCandidature' )]
    #[ORM\JoinColumn(name: 'id_demandeur', referencedColumnName: 'id')]
    #[Groups("Candiadature")]

    private ?User $utilisateurAssocier=null;

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

    public function getUtilisateurAssocier(): ?User
    {
        return $this->utilisateurAssocier;
    }

    public function setUtilisateurAssocier(?User $utilisateurAssocier): self
    {
        $this->utilisateurAssocier = $utilisateurAssocier;

        return $this;
    }


}
