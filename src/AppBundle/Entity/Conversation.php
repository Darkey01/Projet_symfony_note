<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conversation
 *
 * @ORM\Table(name="conversation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConversationRepository")
 */
class Conversation
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
     * @ORM\ManyToMany(targetEntity="Proprietaire", mappedBy="conversations")
     */
    private $personnes;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="idConversation")
     */
    private $messages;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;


    /**
     * @ORM\OneToOne(targetEntity="Projet")
     *
     */
    private $projetId;

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
    public function getPersonnes()
    {
        return $this->personnes;
    }

    /**
     * @param mixed $personnes
     */
    public function setPersonnes($personnes)
    {
        $this->personnes = $personnes;
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
     * @return mixed
     */
    public function getProjetId()
    {
        return $this->projetId;
    }

    /**
     * @param mixed $projetId
     */
    public function setProjetId($projetId)
    {
        $this->projetId = $projetId;
    }

}

