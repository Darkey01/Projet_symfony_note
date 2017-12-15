<?php
/**
 * Created by PhpStorm.
 * Propietaire: Reynald
 * Date: 01/12/2017
 * Time: 14:01
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="propietaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProprietaireRepository")
 */
class Propietaire
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
}