<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Charge
 *
 * @ORM\Table(name="charge")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChargeRepository")
 */
class Charge
{

    public function __construct() {
        $this->proprietaires = new ArrayCollection();
    }

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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEcheance", type="date")
     */
    private $dateEcheance;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=20, columnDefinition="ENUM('Paye', 'A payer')")
     */

    private $statut;

    /**
     * @ORM\ManyToMany(targetEntity="Proprietaire" , mappedBy="charges")
     */
    private $proprietaires;

    public function addPropietaire(Proprietaire $proprietaire)
    {
        $this->proprietaires[] = $proprietaire;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="pieceJointe", type="blob", nullable=true)
     */
    private $pieceJointe;


    /**
     * @@ORM\ManyToOne(targetEntity="Contrat")
     * @ORM\JoinColumn(nullable=true)
     */
    private $contrat;


    /**
     * @ORM\OneToMany(targetEntity="Versement", mappedBy="chargeLiee")
     */
    private $versements;

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
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @param float $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * @return \DateTime
     */
    public function getDateEcheance()
    {
        return $this->dateEcheance;
    }

    /**
     * @param \DateTime $dateEcheance
     */
    public function setDateEcheance($dateEcheance)
    {
        $this->dateEcheance = $dateEcheance;
    }

    /**
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param string $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    /**
     * @return mixed
     */
    public function getProprietaires()
    {
        return $this->proprietaires;
    }

    /**
     * @param mixed $proprietaires
     */
    public function setProprietaires($proprietaires)
    {
        $this->proprietaires = $proprietaires;
    }

    /**
     * @return string
     */
    public function getPieceJointe()
    {
        return $this->pieceJointe;
    }

    /**
     * @param string $pieceJointe
     */
    public function setPieceJointe($pieceJointe)
    {
        $this->pieceJointe = $pieceJointe;
    }

    /**
     * @return mixed
     */
    public function getContrat()
    {
        return $this->contrat;
    }

    /**
     * @param mixed $contrat
     */
    public function setContrat($contrat)
    {
        $this->contrat = $contrat;
    }

    /**
     * @return mixed
     */
    public function getVersements()
    {
        return $this->versements;
    }

    /**
     * @param mixed $versements
     */
    public function setVersements($versements)
    {
        $this->versements = $versements;
    }

}

