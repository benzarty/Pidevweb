<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Supportcours
 *
 * @ORM\Table(name="supportcours", indexes={@ORM\Index(name="Id_professeur", columns={"Id_professeur"})})
 * @ORM\Entity
 */
class Supportcours
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_supportCours", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSupportcours;

    /**
     * @var string
     *
     * @ORM\Column(name="support", type="string", length=300, nullable=false)
     */
    private $support;

    /**
     * @var string
     *
     * @ORM\Column(name="image_cours", type="string", length=200, nullable=false)
     */
    private $imageCours;

    /**
     * @var string
     *
     * @ORM\Column(name="date_depot", type="string", length=200, nullable=false)
     */
    private $dateDepot;

    /**
     * @var string
     *
     * @ORM\Column(name="langue_cours", type="string", length=300, nullable=false)
     */
    private $langueCours;

    /**
     * @var \Professeur
     *
     * @ORM\ManyToOne(targetEntity="Professeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_professeur", referencedColumnName="Id_professeur")
     * })
     */
    private $idProfesseur;

    public function getIdSupportcours(): ?int
    {
        return $this->idSupportcours;
    }

    public function getSupport(): ?string
    {
        return $this->support;
    }

    public function setSupport(string $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getImageCours(): ?string
    {
        return $this->imageCours;
    }

    public function setImageCours(string $imageCours): self
    {
        $this->imageCours = $imageCours;

        return $this;
    }

    public function getDateDepot(): ?string
    {
        return $this->dateDepot;
    }

    public function setDateDepot(string $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getLangueCours(): ?string
    {
        return $this->langueCours;
    }

    public function setLangueCours(string $langueCours): self
    {
        $this->langueCours = $langueCours;

        return $this;
    }

    public function getIdProfesseur(): ?Professeur
    {
        return $this->idProfesseur;
    }

    public function setIdProfesseur(?Professeur $idProfesseur): self
    {
        $this->idProfesseur = $idProfesseur;

        return $this;
    }


}
