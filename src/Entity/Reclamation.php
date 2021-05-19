<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="IDU", columns={"id_user"})})
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
     * @var string|null
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     *     * @Assert\Length(min = 3 ,max = 40,
     *     minMessage = "Le titre d'une reclamation doit comporter au moins {{ limit }} caractères",
     *     maxMessage = "Le titre d'une reclamation doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $title;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(name="etat", type="string", length=50, nullable=false, options={"default"="non-traitée"})
     * @Assert\NotBlank(message="Vous devez remplir ce champs")
     */
    private $etat = 'non-traitée';

    /**
     * @var string|null
     * @ORM\Column(name="recl", type="text", length=65535, nullable=true)
     * @Assert\Length(min = 2,
     * minMessage = "La reclamation doit comporter au moins {{ limit }} caractères")
     */
    private $recl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reclmodif", type="text", length=65535, nullable=true)
     */
    private $reclmodif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="exp", type="string", length=222, nullable=true)
     */
    private $exp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="msg", type="string", length=222, nullable=true)
     */
    private $msg;

    /**
     * @var string|null
     *
     * @ORM\Column(name="msgA", type="string", length=222, nullable=true)
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

    public function getUN(): ?string
    {
        return $this->username;
    }

    public function setUN(?string $username): self
    {
        $this->username = $username;

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

    public function setDate(?\DateTimeInterface $date): self
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

    public function setRecl(?string $recl): self
    {
        $this->recl = $recl;

        return $this;
    }

    public function getReclmodif(): ?string
    {
        return $this->reclmodif;
    }

    public function setReclmodif(?string $reclmodif): self
    {
        $this->reclmodif = $reclmodif;

        return $this;
    }

    public function getExp(): ?string
    {
        return $this->exp;
    }

    public function setExp(?string $exp): self
    {
        $this->exp = $exp;

        return $this;
    }

    public function getMsg(): ?string
    {
        return $this->msg;
    }

    public function setMsg(?string $msg): self
    {
        $this->msg = $msg;

        return $this;
    }

    public function getMsgA(): ?string
    {
        return $this->msgA;
    }

    public function setMsgA(?string $msgA): self
    {
        $this->msgA = $msgA;

        return $this;
    }


}
