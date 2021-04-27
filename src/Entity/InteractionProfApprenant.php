<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InteractionProfApprenant
 *
 * @ORM\Table(name="interaction_prof_apprenant")
 * @ORM\Entity
 */
class InteractionProfApprenant
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
     * @var string
     *
     * @ORM\Column(name="lien", type="string", length=300, nullable=false)
     */
    private $lien;

    public function getIdInteractionProfApprenant(): ?int
    {
        return $this->idInteractionProfApprenant;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }


}