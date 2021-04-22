<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PromotionRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion", indexes={@ORM\Index(name="id_apprenant", columns={"id_apprenant"}), @ORM\Index(name="id_professeur", columns={"id_professeur"})})
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_promotion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPromotion;

    /**
     * @var string
     *
     * @ORM\Column(name="promotion", type="string", length=300, nullable=false)
     */
    private $promotion;

    /**
     * @var string
     *
     * @ORM\Column(name="raison_promotion", type="string", length=300, nullable=false)
     */
    private $raisonPromotion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_promotion", type="date", nullable=false)
     */
    private $datePromotion;

    /**
     * @var \Professeur
     *
     * @ORM\ManyToOne(targetEntity="Professeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_professeur", referencedColumnName="Id_professeur")
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

    public function getIdPromotion(): ?int
    {
        return $this->idPromotion;
    }

    public function getPromotion(): ?string
    {
        return $this->promotion;
    }

    public function setPromotion(string $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getRaisonPromotion(): ?string
    {
        return $this->raisonPromotion;
    }

    public function setRaisonPromotion(string $raisonPromotion): self
    {
        $this->raisonPromotion = $raisonPromotion;

        return $this;
    }

    public function getDatePromotion(): ?\DateTimeInterface
    {
        return $this->datePromotion;
    }

    public function setDatePromotion(\DateTimeInterface $datePromotion): self
    {
        $this->datePromotion = $datePromotion;

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
