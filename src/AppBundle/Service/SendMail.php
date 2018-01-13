<?php
/**
 * Created by PhpStorm.
 * User: Reynald
 * Date: 12/01/2018
 * Time: 15:46
 */

namespace AppBundle\Service;


use AppBundle\Entity\Conversation;
use AppBundle\Entity\Projet;
use AppBundle\Entity\Proprietaire;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class SendMail
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;

    }

    public function sendMailNewProjet(Proprietaire $proprietaire,Proprietaire $userCurrent,Projet $projet ){
        if ($proprietaire->getUser()->getEmail() != null) {
            $message = (new \Swift_Message("Notification : création " . $projet->getNom()))
                ->setFrom('noreply@yopmail.com')
                ->setTo($proprietaire->getUser()->getEmail())
                ->setBody("Madame, Monsieur, " . $userCurrent . " viens de créer un projet "  . $projet->getNom() . " concernant la co-propriété et vous concernant également. Cordialement");
            $this->container->get('mailer')->send($message);
        }
    }

    public function sendMailEditProjet(Proprietaire $proprietaire,Proprietaire $userCurrent,Projet $projet ){
        if ($proprietaire->getUser()->getEmail() != null) {
            $message = (new \Swift_Message("Notification : modification " . $projet->getNom()))
                ->setFrom('noreply@yopmail.com')
                ->setTo($proprietaire->getUser()->getEmail())
                ->setBody("Madame, Monsieur, " . $userCurrent . " viens d'apporter une modification au projet " . $projet->getNom() . " . Cordialement");
            $this->container->get('mailer')->send($message);
        }
    }

    public function sendMailNewConversation(Proprietaire $proprietaire,Proprietaire $userCurrent, Conversation $conversation){
        if ($proprietaire->getUser()->getEmail() != null) {
            $message = (new \Swift_Message("Notification : Création d'un sujet de conversation " . $conversation->getTitre()))
                ->setFrom('noreply@yopmail.com')
                ->setTo($proprietaire->getUser()->getEmail())
                ->setBody("Madame, Monsieur, " . $userCurrent . " viens de créer un conversation vous concernant. Cordialement");
            $this->container->get('mailer')->send($message);
        }
    }


    public function sendMailNewMessageConversation(Proprietaire $proprietaire,Proprietaire $userCurrent,Conversation $conversation){
        if ($proprietaire->getUser()->getEmail() != null) {
            $message = (new \Swift_Message("Notification : Une réponse a été émise a la conversation " . $conversation->getTitre()))
                ->setFrom('noreply@yopmail.com')
                ->setTo($proprietaire->getUser()->getEmail())
                ->setBody("Madame, Monsieur, " . $userCurrent . " viens répondre à la conversation " . $conversation->getTitre() . " . Cordialement");
            $this->container->get('mailer')->send($message);
        }
    }
}