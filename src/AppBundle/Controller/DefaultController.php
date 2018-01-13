<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render(
            'AppBundle:Security:login.html.twig',
            [
            ]
        );
    }
    /**
     *
     * @Route("propietaire/accueil", name="dashboard")
     * @Route("proprietaire/", name="dashboard")
     * @Method("GET")
     */
    public function dashboardAction(){
        $charges = [];
        $montants = [];
        foreach ($this->getUser()->getIdProprietaire()->getCharges() as $charge) {
        $montanttotprop = $charge->getMontant() / count($charge->getProprietaires());
        $montantpayeprop = 0;
        foreach ($this->getUser()->getIdProprietaire()->getVersements() as $versementUser) {
            if ($versementUser->getChargeLiee() == $charge) {
                $montantpayeprop = $montantpayeprop + $versementUser->getMontant();
            }
        }
        if($montanttotprop - $montantpayeprop > 0){
            $charges[] = $charge;
            $montants[$charge->getId()] = $montanttotprop - $montantpayeprop ;
        }
    }

        return $this->render('proprietaire/dashboard.html.twig', array(
            "charges"=> $charges,
            "montants" => $montants
            ));
    }


}
