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
     * @ManyToMany(targetEntity="User")
     * @JoinTable(name="personnesConversations",
     *     joinColumns={@JoinColumn(name="conversation_id", referencedColumnName="id")})
     */
    private $personnes;

    /**
     * @OneToMany(targetEntity="Message", mappedBy="idConversation")
     */
    private $messages;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;


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
     * Set personnes
     *
     * @param array $personnes
     *
     * @return Conversation
     */
    public function setPersonnes($personnes)
    {
        $this->personnes = $personnes;

        return $this;
    }

    /**
     * Get personnes
     *
     * @return array
     */
    public function getPersonnes()
    {
        return $this->personnes;
    }

    /**
     * Set messages
     *
     * @param array $messages
     *
     * @return Conversation
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get messages
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Conversation
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
}

