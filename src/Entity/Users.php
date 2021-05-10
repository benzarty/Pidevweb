<?php

namespace App\Entity;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\UsersRepository;
/**
 * Users
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @ORM\Table(name="users")
 * @ORM\Entity
 *@UniqueEntity(
 *     fields={"email"},
 *     message="This Mail is aleady used."
 * )
 */
class Users implements UserInterface
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     * *@Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Le nom d'un article doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom d'un article doit comporter au plus {{ limit }} caractères"
     * )
     *@Assert\NotBlank (message="Vous devez remplir ce champs")
     */
    private $nom;


    public function setId(?int $id): void
    {
        $this->id = $id;
    }



    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, nullable=false)
     */
    private $role;


    /**
     * @var string
     *
     * @ORM\Column(name="codesecurity", type="integer", nullable=true)
     */
    private $codesecurity;
    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     *  @Assert\Length(
     *      min = 3,
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
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     *@Assert\Email(message = "The email '{{ value }}' is not a valid email.",
     * mode = "strict")
     *@Assert\NotBlank(message="Vous devez remplir ce champs")
     *
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=500, nullable=false)
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "Le Password doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le Password doit comporter au plus {{ limit }} caractères"
     * )
     * @Assert\NotBlank(message="Vous devez remplir ce champs")
     * @Assert\EqualTo(propertyPath="confirmPassword",message="votre mot de passe doit etre identique bro")
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="specialite", type="string", length=255, nullable=true)
     */
    private $specialite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="profil", type="string", length=255, nullable=true)
     */
    private $profil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    private $confirmPassword;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
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

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(?string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getProfil(): ?string
    {
        return $this->profil;
    }

    public function setProfil(?string $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
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


    public function getRoles()
    {
        return ['ROLE_Apprenant'];
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->nom;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __toString(){
        // to show the name of the Category in the select
        return $this->nom . "   " . $this->prenom;
        // to show the id of the Category in the select
        // return $this->id;
    }

    /**
     * @return int
     */
    public function getCodesecurity(): int
    {
        return $this->codesecurity;
    }

    /**
     * @param int $codesecurity
     */
    public function setCodesecurity(int $codesecurity): void
    {
        $this->codesecurity = $codesecurity;
    }

}
