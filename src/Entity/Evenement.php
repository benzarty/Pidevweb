<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EvenementRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_evenement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvenement;

    /**
     * @var string
     *
     * @ORM\Column(name="lien", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Url(message = "Gickel url '{{ value }}' is not a valid url", protocols = {"http", "https"})
     *
     */
    private $lien;

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length (
     *     min = "5",
     *     max = "50",
     *     minMessage =" Veuillez saisir plus de 5 caractere",
     *     maxMessage =" Veuillez saisir moins de 50 caractere")
     *
     */
    private $theme;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_evenement", type="date", nullable=false)
     * @Assert\NotBlank
     * @ORM\Column(name="date_evenement", type="date", nullable=false)
     *
     */
    private $dateEvenement;

    /**
     * @var string
     *
     * @ORM\Column(name="presentateur", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message = "Veuillez saisir le presentateur")
     * @Assert\Length(
     *     max = "50"
     *     )
     *
     */
    private $presentateur;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=500, nullable=false)
     * @Assert\NotBlank(message="Vous devez remplir ce champs")
     */
    private $image;

    public function getIdEvenement(): ?int
    {
        return $this->idEvenement;
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

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getDateEvenement(): ?\DateTimeInterface
    {
        return $this->dateEvenement;
    }

    public function setDateEvenement(\DateTimeInterface $dateEvenement): self
    {
        $this->dateEvenement = $dateEvenement;

        return $this;
    }

    public function getPresentateur(): ?string
    {
        return $this->presentateur;
    }

    public function setPresentateur(string $presentateur): self
    {
        $this->presentateur = $presentateur;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }


}
