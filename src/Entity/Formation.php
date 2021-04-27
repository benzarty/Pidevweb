<?php

namespace App\Entity;

use Exception;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\File;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Formation
 *
 * @ORM\Table(name="Formation")
 * @ORM\Entity
 */
class Formation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_formation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFormation;


    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_users", referencedColumnName="id")
     * })
     */
    private $idprof;

    /**
     * @return \Users
     */
    public function getIdprof(): \Users
    {
        return $this->idprof;
    }

    /**
     * @param \Users $idprof
     */
    public function setIdprof(\Users $idprof): void
    {
        $this->idprof = $idprof;
    }




    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=50, nullable=false)
     *@Assert\Length(
     *      min = 8,
     *      max = 50,
     *      minMessage = "L'intitulé d'une formation doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "L'intitulé d'une formation ne doit pas depasser {{ limit }} caractères"
     * )
     *@Assert\NotBlank (message="Vous devez remplir ce champs")
     */
    private $intitule;

    /**
     * @var \DateTime
     * @Assert\NotBlank
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     * @Assert\NotBlank
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var int
     *
     * @ORM\Column(name="volume_horaire", type="integer", nullable=false)
     *@Assert\NotBlank(message="Vous devez remplir ce champs")
     */
    private $volumeHoraire;


    /**
     * @return string
     */
    public function getPhoto(): string
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }





    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=50, nullable=false, options={"default"="French"})
     *@Assert\NotBlank(message="Vous devez remplir ce champs")
     */
    private $langue;
    /**
     * @var string
     *
     * @ORM\Column(name="mode_enseignement", type="string", length=50, nullable=false, options={"default"="presentiel"})
     *@Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $modeEnseignement;

    public function getIdFormation(): ?int
    {
        return $this->idFormation;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getVolumeHoraire(): ?int
    {
        return $this->volumeHoraire;
    }

    public function setVolumeHoraire(int $volumeHoraire): self
    {
        $this->volumeHoraire = $volumeHoraire;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getModeEnseignement(): ?string
    {
        return $this->modeEnseignement;
    }

    public function setModeEnseignement(string $modeEnseignement): self
    {
        $this->modeEnseignement = $modeEnseignement;

        return $this;
    }

}











