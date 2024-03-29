<?php

namespace App\Entity;

use App\Repository\PostulationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PostulationRepository::class)]

class
Postulation
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("Postulation")]

    private $id;

    #[ORM\Column(length: 50)]
    #[Groups("Postulation")]

    private ?string $etat = null;


    #[Groups("Postulation")]

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;





    #[ORM\ManyToOne(inversedBy:'listePostulationInAnnonce' )]
    #[ORM\JoinColumn(name: 'id_annonce', referencedColumnName: 'id_annonce')]
    #[Groups("Annonce")]

    private ?Annonce $annoncePostulation;



    #[ORM\ManyToOne(inversedBy:'listePostulationInUser' )]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id')]
    #[Groups("User")]

    private ?User $userPostulation;


    #[ORM\ManyToOne(inversedBy:'listePostulation' )]
    #[ORM\JoinColumn(name: 'id_file', referencedColumnName: 'id_file')]
    #[Groups("File")]

    private ?File $fileAssocier;


    public function __construst()
    {
        $this->date=new \DateTime();
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
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

    public function getAnnoncePostulation(): ?Annonce
    {
        return $this->annoncePostulation;
    }

    public function setAnnoncePostulation(?Annonce $annoncePostulation): self
    {
        $this->annoncePostulation = $annoncePostulation;

        return $this;
    }

    public function getUserPostulation(): ?User
    {
        return $this->userPostulation;
    }

    public function setUserPostulation(?User $userPostulation): self
    {
        $this->userPostulation = $userPostulation;

        return $this;
    }

    public function getFileAssocier(): ?File
    {
        return $this->fileAssocier;
    }

    public function setFileAssocier(?File $fileAssocier): self
    {
        $this->fileAssocier = $fileAssocier;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


}
