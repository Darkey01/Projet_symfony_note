<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Proprietaire;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Proprietaire controller.
 *
 * @Route("admin")
 */
class ProprietaireController extends Controller
{
    /**
     * Lists all proprietaire entities.
     *
     * @Route("/accueil", name="accueil_admin")
     * @Route("/", name="accueil_admin")
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
     * Creates a new proprietaire entity.
     *
     * @Route("/proprietaire/new", name="addProprietaire")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $user->setRoles(array('ROLE_PROPRIETAIRE'));
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $pwdnotencoded = $data->getPassword();

            $encoder = $this->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user,$pwdnotencoded);
            $user->setPassword($encoded);
            $proprietaire = new Proprietaire();
            $proprietaire->setUser($user);
            $user->setIdProprietaire($proprietaire);
            $em = $this->getDoctrine()->getManager();
            $em->persist($proprietaire);
            $em->flush();


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('proprietaire_show', array('id' => $proprietaire->getId()));
        }

        return $this->render('AppBundle:User:new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }



    /**
     * Finds and displays a proprietaire entity.
     *
     * @Route("/proprietaire/{id}", name="proprietaire_show")
     * @Method("GET")
     */
    public function showAction(Proprietaire $proprietaire)
    {

        return $this->render('proprietaire/show.html.twig', array(
            'proprietaire' => $proprietaire,
        ));
    }
}
