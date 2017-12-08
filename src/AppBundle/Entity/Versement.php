<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Versement
 *
 * @ORM\Table(name="versement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VersementRepository")
 */
class Versement
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
     * @ManyToOne(targetEntity="User")
     */
    private $proprietaire;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @OneToMany(targetEntity="PieceJointe", mappedBy="id")
     */

    private $piecesJointes;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, columnDefinition="ENUM('Cheque', 'Virement bancaire')"))
     */
    private $type;

    /**
     * @ManyToOne(targetEntity="Charge")
     */
    private $chargeLiee;


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
     * Set proprietaire
     *
     * @param string $proprietaire
     *
     * @return Versement
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
     * Set montant
     *
     * @param float $montant
     *
     * @return Versement
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Versement
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set piecesJointes
     *
     * @param array $piecesJointes
     *
     * @return Versement
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
     * Set type
     *
     * @param string $type
     *
     * @return Versement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set chargeLiee
     *
     * @param \stdClass $chargeLiee
     *
     * @return Versement
     */
    public function setChargeLiee($chargeLiee)
    {
        $this->chargeLiee = $chargeLiee;

        return $this;
    }

    /**
     * Get chargeLiee
     *
     * @return \stdClass
     */
    public function getChargeLiee()
    {
        return $this->chargeLiee;
    }
}

