<?php


namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Apprenant2Repository;

/**
 * Apprenant2
 *
 * @ORM\Table(name="apprenant", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity(repositoryClass=Apprenant2Repository::class)
 */

class Apprenant2 extends User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_apprenant", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idApprenant;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50, nullable=false)
     */
    private $status;

    /**
     * Apprenant2 constructor.
     * @param int id_apprenant
     * @param string $status
     */
    public function __construct(int $id_apprenant, string $status)
    {
        parent::__construct();
        $this->id_apprenant = $id_apprenant;
        $this->status = $status;
    }


    /**
     * @return int
     */
    public function getIdApprenant(): int
    {
        return $this->idApprenant;
    }

    /**
     * @param int $idApprenant
     */
    public function setIdApprenant(int $id_apprenant): void
    {
        $this->id_apprenant = $id_apprenant;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }




}