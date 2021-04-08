<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emploidetemps
 *
 * @ORM\Table(name="emploidetemps", indexes={@ORM\Index(name="idprof", columns={"idprof"})})
 * @ORM\Entity
 */
class Emploidetemps
{
    /**
     * @var int
     *
     * @ORM\Column(name="idemploi", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idemploi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedebutvalidite", type="date", nullable=false)
     */
    private $datedebutvalidite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefinvalidite", type="date", nullable=false)
     */
    private $datefinvalidite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateajoutemploi", type="date", nullable=false)
     */
    private $dateajoutemploi;

    /**
     * @var string
     *
     * @ORM\Column(name="emploi", type="string", length=255, nullable=false)
     */
    private $emploi;

    /**
     * @var \Professeur
     *
     * @ORM\ManyToOne(targetEntity="Professeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idprof", referencedColumnName="Id_professeur")
     * })
     */
    private $idprof;

    public function getIdemploi(): ?int
    {
        return $this->idemploi;
    }

    public function getDatedebutvalidite(): ?\DateTimeInterface
    {
        return $this->datedebutvalidite;
    }

    public function setDatedebutvalidite(\DateTimeInterface $datedebutvalidite): self
    {
        $this->datedebutvalidite = $datedebutvalidite;

        return $this;
    }

    public function getDatefinvalidite(): ?\DateTimeInterface
    {
        return $this->datefinvalidite;
    }

    public function setDatefinvalidite(\DateTimeInterface $datefinvalidite): self
    {
        $this->datefinvalidite = $datefinvalidite;

        return $this;
    }

    public function getDateajoutemploi(): ?\DateTimeInterface
    {
        return $this->dateajoutemploi;
    }

    public function setDateajoutemploi(\DateTimeInterface $dateajoutemploi): self
    {
        $this->dateajoutemploi = $dateajoutemploi;

        return $this;
    }

    public function getEmploi(): ?string
    {
        return $this->emploi;
    }

    public function setEmploi(string $emploi): self
    {
        $this->emploi = $emploi;

        return $this;
    }

    public function getIdprof(): ?Professeur
    {
        return $this->idprof;
    }

    public function setIdprof(?Professeur $idprof): self
    {
        $this->idprof = $idprof;

        return $this;
    }


}
