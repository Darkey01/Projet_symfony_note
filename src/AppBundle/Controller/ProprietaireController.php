<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @Route("/user")
 */
class ProprietaireController extends Controller
{
    /**
     * @Route("/", name="listUser")
     */
    public function listAction()
    {
        return $this->render('AppBundle:Propietaire:list.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route(" /{id}", requirements={"id" = "\d+"})
     */
    public function detailsAction($id)
    {
        return $this->render('AppBundle:Propietaire:detail.html.twig', array(
            // ...
        ));
    }
}
