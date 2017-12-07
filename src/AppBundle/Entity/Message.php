<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="text", type="string", length=510)
     */
    private $text;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="idUser", type="object")
     */
    private $idUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateMessage", type="date")
     */
    private $dateMessage;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="idConversation", type="object")
     */
    private $idConversation;


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
     * Set text
     *
     * @param string $text
     *
     * @return Message
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set idUser
     *
     * @param \stdClass $idUser
     *
     * @return Message
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \stdClass
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set dateMessage
     *
     * @param \DateTime $dateMessage
     *
     * @return Message
     */
    public function setDateMessage($dateMessage)
    {
        $this->dateMessage = $dateMessage;

        return $this;
    }

    /**
     * Get dateMessage
     *
     * @return \DateTime
     */
    public function getDateMessage()
    {
        return $this->dateMessage;
    }

    /**
     * Set idConversation
     *
     * @param \stdClass $idConversation
     *
     * @return Message
     */
    public function setIdConversation($idConversation)
    {
        $this->idConversation = $idConversation;

        return $this;
    }

    /**
     * Get idConversation
     *
     * @return \stdClass
     */
    public function getIdConversation()
    {
        return $this->idConversation;
    }
}

