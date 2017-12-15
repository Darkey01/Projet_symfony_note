<?php
/**
 * Created by PhpStorm.
 * User: Reynald
 * Date: 15/12/2017
 * Time: 11:42
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="proprietaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProprietaireRepository")
 */
class Proprietaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="Conversation")
     * @ORM\JoinTable(name="personnesConversations",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="conversation_id", referencedColumnName="id")}
     *     )
     */
    private $conversations;

    /**
     * @ORM\ManyToMany(targetEntity="Charge")
     * @ORM\JoinTable(name="personnesCharges",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="charge_id", referencedColumnName="id")}
     *     )
     */
    private $charges;

    /**
     * @ORM\OneToMany(targetEntity="Versement", mappedBy="proprietaire")
     */
    private $versements;

    /**
     * @ORM\OneToMany(targetEntity="Projet", mappedBy="proprietaire")
     */
    private $projetsCrees;

    /**
     * @ORM\ManyToMany(targetEntity="Projet")
     * @ORM\JoinTable(name="personnesProjet",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="projet_id", referencedColumnName="id")}
     *     )

     */
    private $projets;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="idUser")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity="ReponseSondage")
     * @ORM\JoinTable(name="Votes",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="reponse_id", referencedColumnName="id")}
     *     )
     */
    private $reponses;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
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
    public function setPassword($password)
    {
        $this->password = $password;
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