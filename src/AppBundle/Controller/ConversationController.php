<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conversation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Conversation controller.
 *
 * @Route("conversation")
 */
class ConversationController extends Controller
{
    /**
     * Lists all conversation entities.
     *
     * @Route("/", name="conversation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conversations = $em->getRepository('AppBundle:Conversation')->findAll();

        return $this->render('conversation/index.html.twig', array(
            'conversations' => $conversations,
        ));
    }

    /**
     * Creates a new conversation entity.
     *
     * @Route("/new", name="conversation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $conversation = new Conversation();
        $form = $this->createForm('AppBundle\Form\ConversationType', $conversation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conversation);
            $em->flush();

            return $this->redirectToRoute('conversation_show', array('id' => $conversation->getId()));
        }

        return $this->render('conversation/new.html.twig', array(
            'conversation' => $conversation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a conversation entity.
     *
     * @Route("/{id}", name="conversation_show")
     * @Method("GET")
     */
    public function showAction(Conversation $conversation)
    {
        $deleteForm = $this->createDeleteForm($conversation);

        return $this->render('conversation/show.html.twig', array(
            'conversation' => $conversation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing conversation entity.
     *
     * @Route("/{id}/edit", name="conversation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Conversation $conversation)
    {
        $deleteForm = $this->createDeleteForm($conversation);
        $editForm = $this->createForm('AppBundle\Form\ConversationType', $conversation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conversation_edit', array('id' => $conversation->getId()));
        }

        return $this->render('conversation/edit.html.twig', array(
            'conversation' => $conversation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a conversation entity.
     *
     * @Route("/{id}", name="conversation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Conversation $conversation)
    {
        $form = $this->createDeleteForm($conversation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($conversation);
            $em->flush();
        }

        return $this->redirectToRoute('conversation_index');
    }

    /**
     * Creates a form to delete a conversation entity.
     *
     * @param Conversation $conversation The conversation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Conversation $conversation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('conversation_delete', array('id' => $conversation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
