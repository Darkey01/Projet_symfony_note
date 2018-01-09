<?php
/**
 * Created by PhpStorm.
 * User: Reynald
 * Date: 09/01/2018
 * Time: 23:31
 */
namespace AppBundle\Service ;

use \AppBundle\Entity\Conversation;
use \AppBundle\Entity\Projet;
use \AppBundle\Entity\Charge;
use \AppBundle\Entity\Proprietaire;

class CheckDroit
{

    public function checkDroitConversation(Proprietaire $user , Conversation $conversation){
        $droit = false;
        foreach($conversation->getPersonnes() as $personne){
            if($personne == $user){
                $droit = true;
                break;
            }
        }
        return $droit;
    }

    public function checkDroitProjet(Proprietaire $user , Projet $projet){
        $droit = false;
        foreach($projet->getPersonnesConcernees() as $personne){
            if($personne == $user){
                $droit = true;
                break;
            }
        }
        return $droit;
    }

    public function checkDroitCharge(Proprietaire $user , Charge $charge){
        $droit = false;
        foreach($charge->getProprietaires() as $personne){
            if($personne == $user){
                $droit = true;
                break;
            }
        }
        return $droit;
    }

}