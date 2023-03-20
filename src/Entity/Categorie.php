<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]

class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCategorie=null;

    #[ORM\Column(length: 50)]
    private ?string $nomCategorie = null;
    #[ORM\OneToMany(mappedBy: 'categorieAnnonce', targetEntity: Annonce::class, orphanRemoval: true)]
    private Collection $listeAnnonce;

    public function __construct()
    {
        $this->listeAnnonce = new ArrayCollection();
    }

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): self
    {
        $this->nomCategorie = $nomCategorie;

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
            $listeAnnonce->setCategorieAnnonce($this);
        }

        return $this;
    }

    public function removeListeAnnonce(Annonce $listeAnnonce): self
    {
        if ($this->listeAnnonce->removeElement($listeAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($listeAnnonce->getCategorieAnnonce() === $this) {
                $listeAnnonce->setCategorieAnnonce(null);
            }
        }

        return $this;
    }

}
