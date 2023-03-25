<?php

namespace App\Entity;
use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:QuestionRepository::class)]

class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idQuestion=null;

    #[ORM\Column(length: 255)]
    private ?string $question=null;

    #[ORM\Column(length: 255)]
    private ?string $propositiona=null;
    #[ORM\Column(length: 255)]
    private ?string $propositionb=null;




    #[ORM\Column(length: 255)]
    private ?string $propositionc=null;

    #[ORM\Column(length: 255)]
    private ?string $idBonnereponse=null;


    #[ORM\ManyToOne(inversedBy:'listeQuestion' )]
    #[ORM\JoinColumn(name: 'id_quiz', referencedColumnName: 'id_quiz')]
    private ?Quiz $QuizAssocier=null;

    public function getIdQuestion(): ?int
    {
        return $this->idQuestion;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getPropositiona(): ?string
    {
        return $this->propositiona;
    }

    public function setPropositiona(string $propositiona): self
    {
        $this->propositiona = $propositiona;

        return $this;
    }

    public function getPropositionb(): ?string
    {
        return $this->propositionb;
    }

    public function setPropositionb(string $propositionb): self
    {
        $this->propositionb = $propositionb;

        return $this;
    }

    public function getPropositionc(): ?string
    {
        return $this->propositionc;
    }

    public function setPropositionc(string $propositionc): self
    {
        $this->propositionc = $propositionc;

        return $this;
    }

    public function getIdBonnereponse(): ?string
    {
        return $this->idBonnereponse;
    }

    public function setIdBonnereponse(string $idBonnereponse): self
    {
        $this->idBonnereponse = $idBonnereponse;

        return $this;
    }

    public function getQuizAssocier(): ?Quiz
    {
        return $this->QuizAssocier;
    }

    public function setQuizAssocier(?Quiz $QuizAssocier): self
    {
        $this->QuizAssocier = $QuizAssocier;

        return $this;
    }


}
