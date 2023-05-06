<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
#[UniqueEntity('sujetQuiz', message: 'Le sujet doit être unique.')]

class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idQuiz = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(message: 'Le nombre de questions doit être un entier positif ou nul.')]
    private ?int $nombreQuestions = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le barem est obligatoire.')]
    #[Assert\Type(type: 'string', message: 'Le barem doit être une chaine de caractères.')]
    private ?string $barem = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le sujet est obligatoire.')]
    #[Assert\Type(type: 'string', message: 'Le sujet doit être une chaine de caractères.')]
    private ?string $sujetQuiz = null;

    #[ORM\ManyToOne(inversedBy:'listeQuiz', cascade:["persist"])]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id')]

    private ?User $userQuiz = null;

    #[ORM\OneToMany(mappedBy: 'QuizAssocier', targetEntity: Question::class, orphanRemoval: true)]
    private Collection $listeQuestion;

    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: Annonce::class, orphanRemoval: true)]
    private Collection $AnnoceAssocier;

    public function __construct()
    {
        $this->listeQuestion = new ArrayCollection();
        $this->AnnoceAssocier = new ArrayCollection();
    }



    public function getIdQuiz(): ?int
    {
        return $this->idQuiz;
    }

    public function getNombreQuestions(): ?int
    {
        return $this->nombreQuestions;
    }

    public function setNombreQuestions(int $nombreQuestions): self
    {
        $this->nombreQuestions = $nombreQuestions;

        return $this;
    }

    public function getBarem(): ?string
    {
        return $this->barem;
    }

    public function setBarem(string $barem): self
    {
        $this->barem = $barem;

        return $this;
    }

    public function getSujetQuiz(): ?string
    {
        return $this->sujetQuiz;
    }

    public function setSujetQuiz(string $sujetQuiz): self
    {
        $this->sujetQuiz = $sujetQuiz;

        return $this;
    }

    public function __toString(): string
{
    return $this->sujetQuiz ?? '';
}


    public function getUserQuiz(): ?User
    {
        return $this->userQuiz;
    }

    public function setUserQuiz(?User $userQuiz): self
    {
        $this->userQuiz = $userQuiz;

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getListeQuestion(): Collection
    {
        return $this->listeQuestion;
    }

    public function addListeQuestion(Question $question): self
{
    if (!$this->listeQuestion->contains($question)) {
        if (!empty($question->getLibelle())) {
            $this->listeQuestion[] = $question;
            $question->setQuiz($this);
        }
    }
    return $this;
}


    public function removeListeQuestion(Annonce $listeQuestion): self
    {
        if ($this->listeQuestion->removeElement($listeQuestion)) {
            // set the owning side to null (unless already changed)
            if ($listeQuestion->getQuizAssocier() === $this) {
                $listeQuestion->setQuizAssocier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnoceAssocier(): Collection
    {
        return $this->AnnoceAssocier;
    }

    public function addAnnoceAssocier(Annonce $annoceAssocier): self
    {
        if (!$this->AnnoceAssocier->contains($annoceAssocier)) {
            $this->AnnoceAssocier->add($annoceAssocier);
            $annoceAssocier->setQuiz($this);
        }

        return $this;
    }

    public function removeAnnoceAssocier(Annonce $annoceAssocier): self
    {
        if ($this->AnnoceAssocier->removeElement($annoceAssocier)) {
            // set the owning side to null (unless already changed)
            if ($annoceAssocier->getQuiz() === $this) {
                $annoceAssocier->setQuiz(null);
            }
        }

        return $this;
    }

}
