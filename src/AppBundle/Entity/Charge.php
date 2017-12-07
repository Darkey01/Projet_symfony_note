<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Charge
 *
 * @ORM\Table(name="charge")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChargeRepository")
 */
class Charge
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
     * @ORM\Column(name="statut", type="string", length=20)
     */
    private $statut;

    /**
     * @var array
     *
     * @ORM\Column(name="proprietaires", type="array")
     */
    private $proprietaires;

    /**
     * @var string
     *
     * @ORM\Column(name="pieceJointe", type="blob", nullable=true)
     */
    private $pieceJointe;


    /**
     * @var \stdClass
     *
     * @ORM\Column(name="contrat", type="object", nullable=true)
     */
    private $contrat;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return Charge
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return Charge
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set dateEcheance
     *
     * @param \DateTime $dateEcheance
     *
     * @return Charge
     */
    public function setDateEcheance($dateEcheance)
    {
        $this->dateEcheance = $dateEcheance;

        return $this;
    }

    /**
     * Get dateEcheance
     *
     * @return \DateTime
     */
    public function getDateEcheance()
    {
        return $this->dateEcheance;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Charge
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
     * Set proprietaires
     *
     * @param array $proprietaires
     *
     * @return Charge
     */
    public function setProprietaires($proprietaires)
    {
        $this->proprietaires = $proprietaires;

        return $this;
    }

    /**
     * Get proprietaires
     *
     * @return array
     */
    public function getProprietaires()
    {
        return $this->proprietaires;
    }

    /**
     * Set pieceJointe
     *
     * @param string $pieceJointe
     *
     * @return Charge
     */
    public function setPieceJointe($pieceJointe)
    {
        $this->pieceJointe = $pieceJointe;

        return $this;
    }

    /**
     * Get pieceJointe
     *
     * @return string
     */
    public function getPieceJointe()
    {
        return $this->pieceJointe;
    }

    /**
     * Set contrat
     *
     * @param \stdClass $contrat
     *
     * @return Charge
     */
    public function setContrat($contrat)
    {
        $this->contrat = $contrat;

        return $this;
    }

    /**
     * Get contrat
     *
     * @return \stdClass
     */
    public function getContrat()
    {
        return $this->contrat;
    }
}

