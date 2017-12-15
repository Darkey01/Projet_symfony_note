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
     * @ORM\ManyToMany(targetEntity="Propietaire", mappedBy="reponses")
     */
     private $users;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idSondage
     *
     * @param integer $idSondage
     *
     * @return ReponseSondage
     */
    public function setIdSondage($idSondage)
    {
        $this->idSondage = $idSondage;

        return $this;
    }

    /**
     * Get idSondage
     *
     * @return int
     */
    public function getIdSondage()
    {
        return $this->idSondage;
    }

    /**
     * Set reponse
     *
     * @param string $reponse
     *
     * @return ReponseSondage
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;

        return $this;
    }

    /**
     * Get reponse
     *
     * @return string
     */
    public function getReponse()
    {
        return $this->reponse;
    }
}

