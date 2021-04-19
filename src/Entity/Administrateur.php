<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\AdministrateurRepository;

/**
 * Administrateur
 * @ORM\Entity(repositoryClass="App\Repository\AdministrateurRepository")
 * @ORM\Table(name="administrateur", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity
 */
class Administrateur implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_admin", type="integer", nullable=false, options={"comment"="Clé primaire"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=50, nullable=false)
     */
    private $photo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=300, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=250, nullable=false)
     */
    private $password;

    public function getIdAdmin(): ?int
    {
        return $this->idAdmin;
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

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
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


    public function getRoles()
    {
        return ['ROLE_ADMINISTRATEUR'];
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->nom;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}