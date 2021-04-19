<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formationapprenant
 *
 * @ORM\Table(name="formationapprenant", indexes={@ORM\Index(name="pk_forma_app_form", columns={"id_formation"}), @ORM\Index(name="formatonAPp", columns={"id_apprenant", "id_formation"}), @ORM\Index(name="IDX_2DB954BF44DEFA09", columns={"id_apprenant"})})
 * @ORM\Entity
 */
class Formationapprenant
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @var \Formation
     *
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_formation", referencedColumnName="id_formation")
     * })
     */
    private $idFormation;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdFormation(): ?Formation
    {
        return $this->idFormation;
    }

    public function setIdFormation(?Formation $idFormation): self
    {
        $this->idFormation = $idFormation;

        return $this;
    }


}
