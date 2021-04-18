<?php

namespace App\Entity;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\ApprenantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Apprenant
 *
 * @ORM\Table(name="apprenant", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})

 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 */
class Apprenant
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_apprenant", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idApprenant;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     *@Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Le nom d'un article doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom d'un article doit comporter au plus {{ limit }} caractères"
     * )
     *@Assert\NotBlank (message="Vous devez remplir ce champs")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50, nullable=false)
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Le prenom d'un article doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le prenom d'un article doit comporter au plus {{ limit }} caractères"
     * )
     *@Assert\NotBlank(message="Vous devez remplir ce champs")
     */
    private $prenom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo", type="string", length=300, nullable=true)
     * @Assert\File(mimeTypes={"image/jpeg"},groups = {"create"})
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     *@Assert\NotBlank(message="Vous devez remplir ce champs")

     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=50, nullable=false)
     * @Assert\Length(
     *      min = 6,
     *      max = 20,
     *      minMessage = "Le Password doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le Password doit comporter au plus {{ limit }} caractères"
     * )
     *@Assert\NotBlank(message="Vous devez remplir ce champs")
     * @Assert\EqualTo(propertyPath="confirmPassword",message="votre mot de passe doit etre identique bro")
     */
    private $password;

private $confirmPassword;
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=250, nullable=false, options={"default"="False"})
     *@Assert\NotBlank(message="Vous devez remplir ce champs")
     *
     */
    private $status = 'False';



    public function getIdApprenant(): ?int
    {
        return $this->idApprenant;
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

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }





}
