<?php

namespace App\Entity;
use App\Repository\FileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileRepository::class)]

class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $idFile;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $cv = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $deplome = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $lettermotivation = null;

    #[ORM\Column(length: 255)]
    private ?string $namecv = null;

    #[ORM\Column(length: 255)]
    private ?string $namedeplome = null;

    #[ORM\Column(length: 255)]
    private ?string $namemotivation = null;

    #[ORM\OneToOne(inversedBy:'file',cascade: ['persist','remove'] )]
    private ?Utilisateur $userFile;
    #[ORM\OneToMany(mappedBy: 'fileAssocier', targetEntity: Candidature::class, orphanRemoval: true)]
    private Collection $listePostulation;

    public function __construct()
    {
        $this->listePostulation = new ArrayCollection();
    }

    public function getIdFile(): ?string
    {
        return $this->idFile;
    }

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getDeplome()
    {
        return $this->deplome;
    }

    public function setDeplome($deplome): self
    {
        $this->deplome = $deplome;

        return $this;
    }

    public function getLettermotivation()
    {
        return $this->lettermotivation;
    }

    public function setLettermotivation($lettermotivation): self
    {
        $this->lettermotivation = $lettermotivation;

        return $this;
    }

    public function getNamecv(): ?string
    {
        return $this->namecv;
    }

    public function setNamecv(string $namecv): self
    {
        $this->namecv = $namecv;

        return $this;
    }

    public function getNamedeplome(): ?string
    {
        return $this->namedeplome;
    }

    public function setNamedeplome(string $namedeplome): self
    {
        $this->namedeplome = $namedeplome;

        return $this;
    }

    public function getNamemotivation(): ?string
    {
        return $this->namemotivation;
    }

    public function setNamemotivation(string $namemotivation): self
    {
        $this->namemotivation = $namemotivation;

        return $this;
    }

    public function getUserFile(): ?Utilisateur
    {
        return $this->userFile;
    }

    public function setUserFile(?Utilisateur $userFile): self
    {
        $this->userFile = $userFile;

        return $this;
    }

    /**
     * @return Collection<int, Candidature>
     */
    public function getListePostulation(): Collection
    {
        return $this->listePostulation;
    }

    public function addListePostulation(Candidature $listePostulation): self
    {
        if (!$this->listePostulation->contains($listePostulation)) {
            $this->listePostulation->add($listePostulation);
            $listePostulation->setFileAssocier($this);
        }

        return $this;
    }

    public function removeListePostulation(Candidature $listePostulation): self
    {
        if ($this->listePostulation->removeElement($listePostulation)) {
            // set the owning side to null (unless already changed)
            if ($listePostulation->getFileAssocier() === $this) {
                $listePostulation->setFileAssocier(null);
            }
        }

        return $this;
    }

}
