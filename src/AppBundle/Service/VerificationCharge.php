<?php
/**
 * Created by PhpStorm.
 * User: Reynald
 * Date: 12/01/2018
 * Time: 17:49
 */

namespace AppBundle\Service;


use AppBundle\Entity\Charge;
use AppBundle\Entity\Versement;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class VerificationCharge
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function checkMontant(Charge $charge){
        $montantpaye = 0;
        $em= $this->container->get('doctrine')->getManager();
        foreach ($charge->getVersements() as $versement){
            $montantpaye = $montantpaye + $versement->getMontant();
        }

            dump($montantpaye);
        dump($charge->getMontant());

        if($charge->getMontant()<= $montantpaye){
            $charge->setStatut("Paye");
            $em->flush();
        }

    }
}