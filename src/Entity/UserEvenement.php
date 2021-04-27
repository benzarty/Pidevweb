<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserEvenement
 *
 * @ORM\Table(name="user_evenement", indexes={@ORM\Index(name="Id_admin", columns={"Id_admin"}), @ORM\Index(name="id_apprenant", columns={"id_apprenant"}), @ORM\Index(name="Id_professeur", columns={"Id_professeur"}), @ORM\Index(name="id_evenement", columns={"id_evenement"})})
 * @ORM\Entity
 */
class UserEvenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user_evenement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUserEvenement;

    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_evenement", referencedColumnName="Id_evenement")
     * })
     */
    private $idEvenement;

    /**
     * @var \Professeur
     *
     * @ORM\ManyToOne(targetEntity="Professeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_professeur", referencedColumnName="Id_professeur")
     * })
     */
    private $idProfesseur;

    /**
     * @var \Administrateur
     *
     * @ORM\ManyToOne(targetEntity="Administrateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_admin", referencedColumnName="Id_admin")
     * })
     */
    private $idAdmin;

    /**
     * @var \Apprenant
     *
     * @ORM\ManyToOne(targetEntity="Apprenant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_apprenant", referencedColumnName="id_apprenant")
     * })
     */
    private $idApprenant;

    public function getIdUserEvenement(): ?int
    {
        return $this->idUserEvenement;
    }

    public function getIdEvenement(): ?Evenement
    {
        return $this->idEvenement;
    }

    public function setIdEvenement(?Evenement $idEvenement): self
    {
        $this->idEvenement = $idEvenement;

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

    public function getIdAdmin(): ?Administrateur
    {
        return $this->idAdmin;
    }

    public function setIdAdmin(?Administrateur $idAdmin): self
    {
        $this->idAdmin = $idAdmin;

        return $this;
    }

    public function getIdApprenant(): ?Apprenant
    {
        return $this->idApprenant;
    }

    public function setIdApprenant(?Apprenant $idApprenant): self
    {
        $this->idApprenant = $idApprenant;

        return $this;
    }


}