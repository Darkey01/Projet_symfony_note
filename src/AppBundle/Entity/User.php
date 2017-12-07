<?php
/**
 * Created by PhpStorm.
 * User: Reynald
 * Date: 01/12/2017
 * Time: 14:01
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class user
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
     * @ORM\Column(type="String", length=100)
     */
    private $mail;

    /**
     * @ORM\Column(type="String", length=100)
     */
    private $password;

    /**
     * @ManyToMany(targetEntity="Conversation")
     * @JoinTable(name="personnesConversations",
     *     joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")})
     */
    private $conversations;

    /**
     * @ManyToMany(targetEntity="Charge")
     * @JoinTable(name="personnesCharges",
     *     joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")})
     */
    private $charges;
}