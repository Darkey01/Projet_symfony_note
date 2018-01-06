<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conversation;
use AppBundle\Entity\Message;
use AppBundle\Entity\Projet;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Projet controller.
 *
 * @Route("proprietaire/projet")
 */
class ProjetController extends Controller
{
    /**
     * Lists all projet entities.
     *
     * @Route("/", name="projet_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $projets = $this->getUser()->getIdProprietaire()->getProjets();


        return $this->render('projet/index.html.twig', array(
            'projets' => $projets,
        ));
    }

    /**
     * Creates a new projet entity.
     *
     * @Route("/new", name="projet_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $projet = new Projet();
        $form = $this->createForm('AppBundle\Form\ProjetType', $projet,array('user' => $this->getUser()->getId()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $conversation = new Conversation();
            foreach($projet->getPersonnesConcernees() as $proprietaire){
                $proprietaire->addProjet($projet);
                $proprietaire->addConversation($conversation);
            }

            $repositoryProprietaire = $this->getDoctrine()->getManager()->getRepository('AppBundle:Proprietaire');
            $proprietaire = $repositoryProprietaire->find($this->getUser()->getIdProprietaire());
            //$conversation->getPersonnes()->add($Proprietaire);
            $proprietaire->addConversation($conversation);
            $proprietaire->addProjet($projet);
            $projet->setProprietaire($this->getUser()->getIdProprietaire());
            $projet->setFilDiscussion($conversation);
            $projet->setStatut("En discussion");
            $conversation->setProjetId($projet);
            $conversation->setTitre("Projet ". $projet->getNom());
            $em = $this->getDoctrine()->getManager();

            $em->persist($conversation);
            $em->persist($projet);
            $em->flush();

            return $this->redirectToRoute('projet_show', array('id' => $projet->getId()));
        }

        return $this->render('projet/new.html.twig', array(
            'projet' => $projet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a projet entity.
     *
     * @Route("/{id}", name="projet_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, Projet $projet)
    {
        $message = new Message();
        $form = $this->createForm('AppBundle\Form\MessageType', $message );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setIdConversation($projet->getFilDiscussion());
            $message->setIdUser($this->getUser()->getIdProprietaire());
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
        }

        return $this->render('projet/show.html.twig', array(
            'projet' => $projet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing projet entity.
     *
     * @Route("/{id}/edit", name="projet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Projet $projet)
    {
        $editForm = $this->createFormBuilder($projet)->add('description')->add('statut', ChoiceType::class, array(
            'choices'  => array(
                'En discussion' => 'En discussion',
                'En attente d\'éxécution' => 'En attente d execution',
                'Exécuté' => 'Execute',
            ),
        ))->getForm();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projet_edit', array('id' => $projet->getId()));
        }

        return $this->render('projet/edit.html.twig', array(
            'projet' => $projet,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a projet entity.
     *
     * @Route("/{id}", name="projet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Projet $projet)
    {
        $form = $this->createDeleteForm($projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($projet);
            $em->flush();
        }

        return $this->redirectToRoute('projet_index');
    }

}
