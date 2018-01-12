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
     * @ORM\ManyToOne(targetEntity="Proprietaire",inversedBy="messages", cascade={"persist"})
     */
    private $idUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateMessage", type="datetime")
     */
    private $dateMessage;

    /**
     * @ORM\ManyToOne(targetEntity="Conversation",inversedBy="messages", cascade={"persist"})
     */
    private $idConversation;



    public function __construct()
    {
        $this->dateMessage = new \DateTime('NOW');

    }

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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return \DateTime
     */
    public function getDateMessage()
    {
        return $this->dateMessage;
    }

    /**
     * @param \DateTime $dateMessage
     */
    public function setDateMessage($dateMessage)
    {
        $this->dateMessage = $dateMessage;
    }

    /**
     * @return mixed
     */
    public function getIdConversation()
    {
        return $this->idConversation;
    }

    /**
     * @param mixed $idConversation
     */
    public function setIdConversation($idConversation)
    {
        $this->idConversation = $idConversation;
    }

}

