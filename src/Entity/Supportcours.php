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
     * @ORM\Column(name="Nom_support", type="string", length=300, nullable=false)
     */
    private $nom;


    /**
     * @var string
     *
     * @ORM\Column(name="date_depot", type="string", length=200, nullable=false)
     */
    private $datedepot="220";

    /**
     * @var string
     *
     * @ORM\Column(name="langue_cours", type="string", length=300, nullable=false,options={"default"="French"})
     */
    private $languecours;


    /**
     * @var string
     *
     * @ORM\Column(name="lien_cours", type="string", length=300, nullable=false)
     */
    private $liencours;



    public function getIdSupportcours(): ?int
    {
        return $this->idSupportcours;
    }



    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateDepot(): ?string
    {
        return $this->datedepot;
    }

    public function setDateDepot(string $datedepot): self
    {
        $this->datedepot = $datedepot;

        return $this;
    }

    public function getLangueCours(): ?string
    {
        return $this->languecours;
    }

    public function setLangueCours(string $languecours): self
    {
        $this->languecours = $languecours;

        return $this;
    }



    /**
     * @return string
     */
    public function getLiencours(): ?string
    {
        return $this->liencours;
    }

    /**
     * @param string $liencours
     */
    public function setLiencours(string $liencours): void
    {
        $this->liencours = $liencours;
    }


}