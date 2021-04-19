<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation", indexes={@ORM\Index(name="Id_professeur", columns={"Id_professeur"}), @ORM\Index(name="id_apprenant", columns={"id_apprenant"})})
 * @ORM\Entity
 */
class Evaluation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_evaluation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvaluation;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

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
     * @var \Apprenant
     *
     * @ORM\ManyToOne(targetEntity="Apprenant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_apprenant", referencedColumnName="id_apprenant")
     * })
     */
    private $idApprenant;

    public function getIdEvaluation(): ?int
    {
        return $this->idEvaluation;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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