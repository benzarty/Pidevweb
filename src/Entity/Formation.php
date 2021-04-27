<?php

namespace App\Entity;

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
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=50, nullable=false)
     */
    private $intitule;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var int
     *
     * @ORM\Column(name="volume_horaire", type="integer", nullable=false)
     */
    private $volumeHoraire;

    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=50, nullable=false)
     */
    private $langue;

    /**
     * @var string
     *
     * @ORM\Column(name="mode_enseignement", type="string", length=50, nullable=false)
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