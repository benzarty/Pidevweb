<?php


namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;



    /**
     * @Entity @Table(name="users")
     * @InheritanceType("JOINED")
     * @DiscriminatorColumn(name="discr", type="string")
     * @DiscriminatorMap({"professeur" = "professeur", "apprenant" = "apprenant", "administrateur" = "administrateur"})
     */
class User
{

    /**
     * @Column(type="string")
     * @var string
     **/
    protected $nom;
    /**
     * @Column(type="string")
     * @var string
     **/
    protected $prenom;
    /**
     * @Column(type="string")
     * @var string
     **/
    protected $photo;
    /**
     * @Column(type="datetime")
     **/
    protected $email;
    /**
     * @Column(type="datetime")
     **/
    protected $password;

    /**
     * User constructor.
     * @param string $nom
     * @param string $prenom
     * @param string $photo
     * @param $email
     * @param $password
     */
    public function __construct(string $nom, string $prenom, string $photo, $email, $password)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->photo = $photo;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getPhoto(): string
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }





}