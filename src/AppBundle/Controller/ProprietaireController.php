<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Proprietaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Proprietaire controller.
 *
 * @Route("proprietaire")
 */
class ProprietaireController extends Controller
{
    /**
     * Lists all proprietaire entities.
     *
     * @Route("/", name="proprietaire_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $proprietaires = $em->getRepository('AppBundle:Proprietaire')->findAll();

        return $this->render('proprietaire/index.html.twig', array(
            'proprietaires' => $proprietaires,
        ));
    }



    /**
     * Finds and displays a proprietaire entity.
     *
     * @Route("/{id}", name="proprietaire_show")
     * @Method("GET")
     */
    public function showAction(Proprietaire $proprietaire)
    {

        return $this->render('proprietaire/show.html.twig', array(
            'proprietaire' => $proprietaire,
        ));
    }
}
