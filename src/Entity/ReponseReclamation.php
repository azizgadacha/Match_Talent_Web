<?php

namespace App\Entity;
//use ApiPlatform\Metadata\ApiResource;
//use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ReponseReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ReponseReclamationRepository::class)]
class ReponseReclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idReponse=null;

    #[ORM\Column(length: 50)]
    //#[Assert\NotBlank(message: 'Ce champ est obligatoire')]
    private ?string $reponse = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Date]
    private ?\DateTimeInterface $date = null;


    #[ORM\OneToOne(inversedBy:'reponseReclamation' ,cascade:['persist','remove'])]
    #[ORM\JoinColumn(name: 'id_reclamation', referencedColumnName: 'id_reclamation')]
    
    private ?Reclamation $reclamation=null;
    public function __construct()
    {
        $this->date = new \DateTime();
    }


    public function getIdReponse(): ?int
    {
        return $this->idReponse;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

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

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): self
    {
        // unset the owning side of the relation if necessary
        if ($reclamation === null && $this->reclamation !== null) {
            $this->reclamation->setReponseReclamation(null);
        }

        // set the owning side of the relation if necessary
        //if ($reclamation !== null && $reclamation->getReponseReclamation() !== $this) {
            //$reclamation->setReponseReclamation($this);
        //}

        $this->reclamation = $reclamation;

        return $this;
    }


}