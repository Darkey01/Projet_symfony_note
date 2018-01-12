<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conversation;
use AppBundle\Entity\Message;
use AppBundle\Service\CheckDroit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Conversation controller.
 *
 * @Route("/proprietaire/conversation")
 */
class ConversationController extends Controller
{
    /**
     * Lists all conversation entities.
     *
     * @Route("/", name="conversation")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repositConversation = $this->getDoctrine()->getRepository('AppBundle:Conversation');

        $conversations =  $this->getUser()->getIdProprietaire()->getConversations();

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
        $form = $this->createForm('AppBundle\Form\ConversationType', $conversation,array('user' => $this->getUser()->getId()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $repositoryProprietaire = $this->getDoctrine()->getManager()->getRepository('AppBundle:Proprietaire');
            $proprietaire = $repositoryProprietaire->find($this->getUser()->getIdProprietaire());

            foreach($conversation->getPersonnes() as $personne) {
                $personne->addConversation($conversation);
                if ($personne->getUser()->getEmail() != null) {
                    $message = \Swift_Message::newInstance()
                        ->setSubject("Notification : Création d'un sujet de conversation" . $conversation->getTitre())
                        ->setFrom('no_reply@yopmail.com')
                        ->setTo($personne->getUser()->getEmail())
                        ->setBody("Madame, Monsieur, " . $proprietaire . " viens de créer un conversation vous concernant. Cordialement");
                    $this->get('mailer')->send($message);
                }
            }


            //$conversation->getPersonnes()->add($Proprietaire);
            $proprietaire->addConversation($conversation);

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
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request,CheckDroit $checkDroit, Conversation $conversation)
    {
        if($checkDroit->checkDroitConversation($this->getUser()->getIdProprietaire(), $conversation)) {
            $message = new Message();
            $form = $this->createForm('AppBundle\Form\MessageType', $message);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $message->setIdConversation($conversation);
                $message->setIdUser($this->getUser()->getIdProprietaire());

                foreach($conversation->getPersonnes() as $personne) {
                    if ($personne != $this->getUser()->getIdProprietaire()) {
                        if ($personne->getUser()->getEmail() != null) {
                            $message = \Swift_Message::newInstance()
                                ->setSubject("Notification : Une réponse a été émise a la conversation" . $conversation->getTitre())
                                ->setFrom('noreply@yopmail.com')
                                ->setTo($personne->getUser()->getEmail())
                                ->setBody("Madame, Monsieur, " . $this->getUser()->getIdProprietaire() . " viens répondre à la conversation " . $conversation->getTitre() . " . Cordialement");
                            $this->get('mailer')->send($message);
                        }
                    }
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();
            }
            return $this->render('conversation/show.html.twig', array(
                'conversation' => $conversation,
                'form' => $form->createView(),
                'userIdActive' => $this->getUser()->getidProprietaire()->getId()
            ));
        }else{
            return $this->redirectToRoute('conversation');
        }
    }

    /**
     * Displays a form to edit an existing conversation entity.
     *
     * @Route("/{id}/edit", name="conversation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request,CheckDroit $checkDroit, Conversation $conversation)
    {
        if($checkDroit->checkDroitConversation($this->getUser()->getIdProprietaire(), $conversation)) {
            $editForm = $this->createForm('AppBundle\Form\ConversationType', $conversation);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('conversation_edit', array('id' => $conversation->getId()));
            }

            return $this->render('conversation/edit.html.twig', array(
                'conversation' => $conversation,
                'edit_form' => $editForm->createView(),
            ));
        }else{
            return $this->redirectToRoute('conversation');
        }
    }

    /**
     * Deletes a conversation entity.
     *
     * @Route("/{id}", name="conversation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request,CheckDroit $checkDroit, Conversation $conversation)
    {
        if($checkDroit->checkDroitConversation($this->getUser()->getIdProprietaire(), $conversation)) {

            $form = $this->createDeleteForm($conversation);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($conversation);
                $em->flush();
            }
        }
        return $this->redirectToRoute('conversation');
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
