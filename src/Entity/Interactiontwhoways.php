<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Interactiontwhoways
 *
 * @ORM\Table(name="interactiontwhoways", indexes={@ORM\Index(name="idproflol", columns={"id_professeur"}), @ORM\Index(name="idapprenantlol", columns={"id_apprenant"})})
 * @ORM\Entity
 */
class Interactiontwhoways
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_Interaction_prof_apprenant", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idInteractionProfApprenant;

    /**
     * @var \Apprenant
     *
     * @ORM\ManyToOne(targetEntity="Apprenant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_apprenant", referencedColumnName="id_apprenant")
     * })
     */
    private $idApprenant;

    /**
     * @var \Professeur
     *
     * @ORM\ManyToOne(targetEntity="Professeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_professeur", referencedColumnName="Id_professeur")
     * })
     */
    private $idProfesseur;

    public function getIdInteractionProfApprenant(): ?int
    {
        return $this->idInteractionProfApprenant;
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