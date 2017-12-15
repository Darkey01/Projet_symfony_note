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
     * @ORM\ManyToOne(targetEntity="Proprietaire")
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
     * @ORM\OneToMany(targetEntity="PieceJointe", mappedBy="id")
     */

    private $piecesJointes;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, columnDefinition="ENUM('Cheque', 'Virement bancaire')"))
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Charge")
     */
    private $chargeLiee;

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
    public function getProprietaire()
    {
        return $this->proprietaire;
    }

    /**
     * @param mixed $proprietaire
     */
    public function setProprietaire($proprietaire)
    {
        $this->proprietaire = $proprietaire;
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getPiecesJointes()
    {
        return $this->piecesJointes;
    }

    /**
     * @param mixed $piecesJointes
     */
    public function setPiecesJointes($piecesJointes)
    {
        $this->piecesJointes = $piecesJointes;
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
     * @return mixed
     */
    public function getChargeLiee()
    {
        return $this->chargeLiee;
    }

    /**
     * @param mixed $chargeLiee
     */
    public function setChargeLiee($chargeLiee)
    {
        $this->chargeLiee = $chargeLiee;
    }

}

