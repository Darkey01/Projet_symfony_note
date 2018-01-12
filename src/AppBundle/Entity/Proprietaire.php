<?php
/**
 * Created by PhpStorm.
 * User: Reynald
 * Date: 15/12/2017
 * Time: 11:42
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="proprietaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProprietaireRepository")
 */
class Proprietaire
{
    public function __construct() {
        $this->conversations = new ArrayCollection();
        $this->charges = new ArrayCollection();
        $this->versements = new ArrayCollection();
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="User",cascade={"persist"})
     */
    private $user;


    /**
     * @ORM\ManyToMany(targetEntity="Conversation", inversedBy="personnes")
     * @ORM\JoinTable(name="personnesConversations")
     */
    private $conversations;

    public function addConversation(Conversation $conversation)
    {
        $conversation->addPropietaire($this); // synchronously updating inverse side
        $this->conversations[] = $conversation;
    }


    /**
     * @ORM\ManyToMany(targetEntity="Charge", inversedBy="proprietaires")
     * @ORM\JoinTable(name="personnesCharges")
     */
    private $charges;

    public function addCharge(Charge $charge)
    {
        $charge->addPropietaire($this); // synchronously updating inverse side
        $this->charges[] = $charge;
    }

    /**
     * @ORM\OneToMany(targetEntity="Versement", mappedBy="proprietaire")
     */
    private $versements;


    /**
     * @ORM\OneToMany(targetEntity="Projet", mappedBy="proprietaire")
     */
    private $projetsCrees;

    /**
     * @ORM\ManyToMany(targetEntity="Projet", inversedBy="personnesConcernees")
     * @ORM\JoinTable(name="personnesProjet")
     */
    private $projets;

    public function addProjet(Projet $projet)
    {
        $projet->addPropietaire($this); // synchronously updating inverse side
        $this->projets[] = $projet;
    }

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="idUser",  cascade={"persist"})
     */
    private $messages;

    /**
     *
     *  /**
     * @ORM\ManyToMany(targetEntity="ReponseSondage", inversedBy="users")
     * @ORM\JoinTable(name="votes")
     */
    private $reponses;

    public function addReponse(ReponseSondage $reponse)
    {
        $reponse->addPropietaire($this); // synchronously updating inverse side
        $this->reponses[] = $reponse;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString() {
        return $this->getUser()->getUserName();
    }
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


    /**
     * @return mixed
     */
    public function getConversations()
    {
        return $this->conversations;
    }

    /**
     * @param mixed $conversations
     */
    public function setConversations($conversations)
    {
        $this->conversations = $conversations;
    }

    /**
     * @return mixed
     */
    public function getCharges()
    {
        return $this->charges;
    }

    /**
     * @param mixed $charges
     */
    public function setCharges($charges)
    {
        $this->charges = $charges;
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

    /**
     * @return mixed
     */
    public function getProjetsCrees()
    {
        return $this->projetsCrees;
    }

    /**
     * @param mixed $projetsCrees
     */
    public function setProjetsCrees($projetsCrees)
    {
        $this->projetsCrees = $projetsCrees;
    }

    /**
     * @return mixed
     */
    public function getProjets()
    {
        return $this->projets;
    }

    /**
     * @param mixed $projets
     */
    public function setProjets($projets)
    {
        $this->projets = $projets;
    }

    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param mixed $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return mixed
     */
    public function getReponses()
    {
        return $this->reponses;
    }

    /**
     * @param mixed $reponses
     */
    public function setReponses($reponses)
    {
        $this->reponses = $reponses;
    }
}