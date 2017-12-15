<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Projet
 *
 * @ORM\Table(name="projet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjetRepository")
 */
class Projet
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
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=100, columnDefinition="ENUM('En discussion', 'En attente d execution', 'Execute')")
     */

    private $statut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOuverture", type="date")
     */
    private $dateOuverture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCloture", type="date", nullable=true)
     */
    private $dateCloture;

    /**
     * @ORM\OneToOne(targetEntity="Conversation")
     * @ORM\JoinColumn(name="projetId", referencedColumnName="id", nullable=false)
     */
    private $filDiscussion;

    /**
     * @ORM\OneToMany(targetEntity="Sondage", mappedBy="idProjet")
     */
    private $listeSondage;

    /**
     * @ORM\OneToMany(targetEntity="PieceJointe", mappedBy="idProjet")
     */
    private $piecesJointes;

    /**
     * @ORM\ManyToOne(targetEntity="Propietaire")
     */
    private $proprietaire;

    /**
     * @ORM\ManyToMany(targetEntity="Propietaire" , mappedBy="projets")
     */
    private $personnesConcernees;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Projet
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Projet
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Projet
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set dateOuverture
     *
     * @param \DateTime $dateOuverture
     *
     * @return Projet
     */
    public function setDateOuverture($dateOuverture)
    {
        $this->dateOuverture = $dateOuverture;

        return $this;
    }

    /**
     * Get dateOuverture
     *
     * @return \DateTime
     */
    public function getDateOuverture()
    {
        return $this->dateOuverture;
    }

    /**
     * Set dateCloture
     *
     * @param \DateTime $dateCloture
     *
     * @return Projet
     */
    public function setDateCloture($dateCloture)
    {
        $this->dateCloture = $dateCloture;

        return $this;
    }

    /**
     * Get dateCloture
     *
     * @return \DateTime
     */
    public function getDateCloture()
    {
        return $this->dateCloture;
    }

    /**
     * Set filDiscussion
     *
     * @param \stdClass $filDiscussion
     *
     * @return Projet
     */
    public function setFilDiscussion($filDiscussion)
    {
        $this->filDiscussion = $filDiscussion;

        return $this;
    }

    /**
     * Get filDiscussion
     *
     * @return \stdClass
     */
    public function getFilDiscussion()
    {
        return $this->filDiscussion;
    }

    /**
     * Set listeSondage
     *
     * @param array $listeSondage
     *
     * @return Projet
     */
    public function setListeSondage($listeSondage)
    {
        $this->listeSondage = $listeSondage;

        return $this;
    }

    /**
     * Get listeSondage
     *
     * @return array
     */
    public function getListeSondage()
    {
        return $this->listeSondage;
    }

    /**
     * Set piecesJointes
     *
     * @param array $piecesJointes
     *
     * @return Projet
     */
    public function setPiecesJointes($piecesJointes)
    {
        $this->piecesJointes = $piecesJointes;

        return $this;
    }

    /**
     * Get piecesJointes
     *
     * @return array
     */
    public function getPiecesJointes()
    {
        return $this->piecesJointes;
    }

    /**
     * Set proprietaire
     *
     * @param string $proprietaire
     *
     * @return Projet
     */
    public function setProprietaire($proprietaire)
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    /**
     * Get proprietaire
     *
     * @return string
     */
    public function getProprietaire()
    {
        return $this->proprietaire;
    }

    /**
     * Set personnesConcernees
     *
     * @param array $personnesConcernees
     *
     * @return Projet
     */
    public function setPersonnesConcernees($personnesConcernees)
    {
        $this->personnesConcernees = $personnesConcernees;

        return $this;
    }

    /**
     * Get personnesConcernees
     *
     * @return array
     */
    public function getPersonnesConcernees()
    {
        return $this->personnesConcernees;
    }
}

