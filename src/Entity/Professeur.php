<?php

namespace App\Entity;
use App\Repository\ProfesseurRepository;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Professeur
 *
 * @ORM\Table(name="professeur", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity(repositoryClass=ProfesseurRepository::class)
 */
class Professeur
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_professeur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProfesseur;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Le nom  doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom  doit comporter au plus {{ limit }} caractères"
     * )
     * @Assert\NotBlank(message="Vous devez remplir ce champs")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50, nullable=false)
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Le prenom  doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le prenom  doit comporter au plus {{ limit }} caractères"
     * )
     * @Assert\NotBlank(message="Vous devez remplir ce champs")
     */
    private $prenom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo", type="string", length=300, nullable=true)
     * @Assert\NotBlank(message="Vous devez remplir ce champs")
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     * @Assert\NotBlank(message="Vous devez remplir ce champs")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=50, nullable=false)
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Le Password  doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le Password  doit comporter au plus {{ limit }} caractères"
     * )
     * @Assert\NotBlank(message="Vous devez remplir ce champs")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="specialite", type="string", length=50, nullable=false)
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Le specialite  doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le specialite  doit comporter au plus {{ limit }} caractères"
     * )
     * @Assert\NotBlank(message="Vous devez remplir ce champs")
     */
    private $specialite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="profil", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Le profil  doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le profil  doit comporter au plus {{ limit }} caractères"
     * )
     * @Assert\NotBlank(message="Vous devez remplir ce champs")
     */
    private $profil;

    public function getIdProfesseur(): ?int
    {
        return $this->idProfesseur;
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

    public function setSpecialite(string $specialite): self
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


}
