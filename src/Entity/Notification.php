<?php

namespace App\Entity;
use App\Repository\NotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]

class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idNotification=null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 150)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy:'listeNotification' )]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id')]

    private ?Utilisateur $userNotification=null;

    public function getIdNotification(): ?int
    {
        return $this->idNotification;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUserNotification(): ?Utilisateur
    {
        return $this->userNotification;
    }

    public function setUserNotification(?Utilisateur $userNotification): self
    {
        $this->userNotification = $userNotification;

        return $this;
    }



}
