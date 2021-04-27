<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="IDP", columns={"id_prof"}), @ORM\Index(name="IDU", columns={"id_user"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false, options={"comment"="Clé primaire"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_user", type="integer", nullable=true)
     */
    private $idUser;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_prof", type="integer", nullable=true)
     */
    private $idProf;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=false, options={"default"="non-traitée"})
     */
    private $etat = 'non-traitée';

    /**
     * @var string
     *
     * @ORM\Column(name="recl", type="text", length=65535, nullable=false)
     */
    private $recl;

    /**
     * @var string
     *
     * @ORM\Column(name="reclmodif", type="text", length=65535, nullable=false)
     */
    private $reclmodif;

    /**
     * @var string
     *
     * @ORM\Column(name="exp", type="string", length=222, nullable=false)
     */
    private $exp;

    /**
     * @var string
     *
     * @ORM\Column(name="msg", type="string", length=222, nullable=false)
     */
    private $msg;

    /**
     * @var string
     *
     * @ORM\Column(name="msgA", type="string", length=222, nullable=false)
     */
    private $msgA;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(?int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdProf(): ?int
    {
        return $this->idProf;
    }

    public function setIdProf(?int $idProf): self
    {
        $this->idProf = $idProf;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getRecl(): ?string
    {
        return $this->recl;
    }

    public function setRecl(string $recl): self
    {
        $this->recl = $recl;

        return $this;
    }

    public function getReclmodif(): ?string
    {
        return $this->reclmodif;
    }

    public function setReclmodif(string $reclmodif): self
    {
        $this->reclmodif = $reclmodif;

        return $this;
    }

    public function getExp(): ?string
    {
        return $this->exp;
    }

    public function setExp(string $exp): self
    {
        $this->exp = $exp;

        return $this;
    }

    public function getMsg(): ?string
    {
        return $this->msg;
    }

    public function setMsg(string $msg): self
    {
        $this->msg = $msg;

        return $this;
    }

    public function getMsgA(): ?string
    {
        return $this->msgA;
    }

    public function setMsgA(string $msgA): self
    {
        $this->msgA = $msgA;

        return $this;
    }


}