<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReponseSondage
 *
 * @ORM\Table(name="reponse_sondage")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReponseSondageRepository")
 */
class ReponseSondage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Sondage")
     */
    private $idSondage;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="string", length=255)
     */
    private $reponse;

    /**
     * @ORM\ManyToMany(targetEntity="Proprietaire", mappedBy="reponses")
     */
    private $users;

    public function addPropietaire(Proprietaire $proprietaire)
    {
        $this->users[] = $proprietaire;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdSondage()
    {
        return $this->idSondage;
    }

    /**
     * @param mixed $idSondage
     */
    public function setIdSondage($idSondage)
    {
        $this->idSondage = $idSondage;
    }

    /**
     * @return string
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * @param string $reponse
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

}

