<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * pieceJointe
 *
 * @ORM\Table(name="piece_jointe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\pieceJointeRepository")
 */
class PieceJointe
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="fichier", type="blob")
     */
    private $fichier;

    /**
     * @ORM\ManyToOne(targetEntity="Versement")
     */
    private $versement;

    /**
     * @ORM\ManyToOne(targetEntity="Projet")
     */
    private $idProjet;

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
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * @param string $fichier
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;
    }

    /**
     * @return mixed
     */
    public function getVersement()
    {
        return $this->versement;
    }

    /**
     * @param mixed $versement
     */
    public function setVersement($versement)
    {
        $this->versement = $versement;
    }

    /**
     * @return mixed
     */
    public function getIdProjet()
    {
        return $this->idProjet;
    }

    /**
     * @param mixed $idProjet
     */
    public function setIdProjet($idProjet)
    {
        $this->idProjet = $idProjet;
    }

}

