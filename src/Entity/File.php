<?php

namespace App\Entity;
use App\Repository\FileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
#[ORM\Entity(repositoryClass: FileRepository::class)]

class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['off'])]
    private $idFile;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    #[Groups(['off'])]
    private $cv = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    #[Groups(['off'])]
    private $deplome = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    #[Groups(['off'])]
    private $lettermotivation = null;

    #[ORM\Column(length: 255)]
    #[Groups(['off'])]
    private ?string $namecv = null;

    #[ORM\Column(length: 255)]
    #[Groups(['off'])]
    private ?string $namedeplome = null;

    #[ORM\Column(length: 255)]
    #[Groups(['off'])]
    private ?string $namemotivation = null;

    #[ORM\OneToOne(inversedBy:'file')]
    #[Groups(['off'])]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id')]

    private ?Utilisateur $userFile;
    #[ORM\OneToMany(mappedBy: 'fileAssocier', targetEntity:Postulation::class, orphanRemoval: true)]
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
     * @return Collection<int, Postulation>
     */
    public function getListePostulation(): Collection
    {
        return $this->listePostulation;
    }

    public function addListePostulation(Postulation $listePostulation): self
    {
        if (!$this->listePostulation->contains($listePostulation)) {
            $this->listePostulation->add($listePostulation);
            $listePostulation->setFileAssocier($this);
        }

        return $this;
    }

    public function removeListePostulation(Postulation $listePostulation): self
    {
        if ($this->listePostulation->removeElement($listePostulation)) {
            // set the owning side to null (unless already changed)
            if ($listePostulation->getFileAssocier() === $this) {
                $listePostulation->setFileAssocier(null);
            }
        }

        return $this;
    }


    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $filecv;


    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $filedeplome;


    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $filemtivation;


    /**
     * @return mixed
     */
    public function getFilecv()
    {
        return $this->filecv;
    }

    /**
     * @param mixed $filecv
     */
    public function setFilecv($filecv): void
    {
        $this->filecv = $filecv;
    }

    /**
     * @return mixed
     */
    public function getFiledeplome()
    {
        return $this->filedeplome;
    }

    /**
     * @param mixed $filedeplome
     */
    public function setFiledeplome($filedeplome): void
    {
        $this->filedeplome = $filedeplome;
    }

    /**
     * @return mixed
     */
    public function getFilemtivation()
    {
        return $this->filemtivation;
    }

    /**
     * @param mixed $filemtivation
     */
    public function setFilemtivation($filemtivation): void
    {
        $this->filemtivation = $filemtivation;
    }




    protected  function  getUploadRootDir(){

        return __DIR__.'/../../public/Upload'.$this->getUploadDir();
    }
    protected function getUploadDir(){

        return'';
    }

    public function getUploadFileCv(){
        if (null === $this->getFilecv()) {
            $this->namecv = "3.jpg";
            return;
        }


        $this->getFilecv()->move(
            $this->getUploadRootDir(),
            $this->getFilecv()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->namecv = $this->getFilecv()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->filecv = null;
    }


    public function getUploadFileDeplome(){
        if (null === $this->getFiledeplome()) {
            $this->namedeplome = "3.jpg";
            return;
        }


        $this->getFiledeplome()->move(
            $this->getUploadRootDir(),
            $this->getFiledeplome()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->namedeplome = $this->getFiledeplome()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->filedeplome = null;
    }

    public function getUploadFileMotivation(){
        if (null === $this->getFilemtivation()) {
            $this->namemotivation = "3.jpg";
            return;
        }


        $this->getFilemtivation()->move(
            $this->getUploadRootDir(),
            $this->getFilemtivation()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->namemotivation = $this->getFilemtivation()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->filemtivation = null;
    }


}
