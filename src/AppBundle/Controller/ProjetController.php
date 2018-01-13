<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Activite;
use AppBundle\Entity\Conversation;
use AppBundle\Entity\Message;
use AppBundle\Entity\PieceJointe;
use AppBundle\Entity\Projet;
use AppBundle\Entity\ReponseSondage;
use AppBundle\Entity\Sondage;
use AppBundle\Service\CheckDroit;
use AppBundle\Service\SendMail;
use AppBundle\Service\UploaderPieceJointe;
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
    public function newAction(Request $request, SendMail $sendMail)
    {
        $projet = new Projet();
        $form = $this->createForm('AppBundle\Form\ProjetType', $projet,array('user' => $this->getUser()->getId()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $conversation = $projet->getFilDiscussion();
            $conversation->setTitre("Projet ". $projet->getNom());
            $conversation->setProjetId($projet);
            foreach($projet->getPersonnesConcernees() as $proprietaire){
                $proprietaire->addProjet($projet);
                $proprietaire->addConversation($conversation);
                if ($proprietaire != $this->getUser()->getIdProprietaire()) {
                    $sendMail->sendMailNewProjet($proprietaire,$this->getUser()->getIdProprietaire(), $projet);
                }
            }
            $repositoryProprietaire = $this->getDoctrine()->getManager()->getRepository('AppBundle:Proprietaire');
            $proprietaire = $repositoryProprietaire->find($this->getUser()->getIdProprietaire());
            $proprietaire->addConversation($conversation);
            $proprietaire->addProjet($projet);
            $projet->setProprietaire($this->getUser()->getIdProprietaire());
            $projet->setFilDiscussion($conversation);
            $projet->setStatut("En discussion");

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
    public function showAction(Request $request,CheckDroit $checkDroit,UploaderPieceJointe $uploaderPieceJointe, Projet $projet)
    {
        if($checkDroit->checkDroitProjet($this->getUser()->getIdProprietaire(), $projet)) {

            $message = new Message();
            $form = $this->createForm('AppBundle\Form\MessageType', $message);
            $form->handleRequest($request);
            $activite = new Activite();
            $formActivite = $this->createForm('AppBundle\Form\ActiviteType', $activite);
            $formActivite->handleRequest($request);
            $pieceJointe = new PieceJointe();
            $formPc = $this->createForm('AppBundle\Form\PieceJointeType', $pieceJointe,['isEdit'=>false]);
            $formPc->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {
                $message->setIdConversation($projet->getFilDiscussion());
                $message->setIdUser($this->getUser()->getIdProprietaire());
                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();
                return $this->redirectToRoute('projet_show', array('id' => $projet->getId()));
            }

            if ($formActivite->isSubmitted() && $formActivite->isValid()) {
                $activite->setProjet($projet);
                $activite->setRedacteur($this->getUser()->getIdProprietaire());
                $em = $this->getDoctrine()->getManager();
                $em->persist($activite);
                $em->flush();
                return $this->redirectToRoute('projet_show', array('id' => $projet->getId()));
            }

            if($formPc->isSubmitted() && $formPc->isValid()) {
                $pieceJointe->setIdProjet($projet);

                if ($uploaderPieceJointe->upload($pieceJointe, $formPc)) {
                    $this->addFlash('info', "Pièce jointe uploader !");
                } else {
                    $this->addFlash('error', 'Extension invalide');

                }
                return $this->redirectToRoute('projet_show', array('id' => $projet->getId()));

            }
            return $this->render('projet/show.html.twig', array(
                'projet' => $projet,
                'form' => $form->createView(),
                'formActivite' => $formActivite->createView(),
                'formPc' => $formPc->createView(),
            ));
        }else{
            return $this->redirectToRoute('projet_index');
        }
    }


    /**
     * Finds and displays a projet entity.
     *
     * @Route("/addvote/{id}", name="projet_sondage_vote")
     * @Method({"GET", "POST"})
     */
    public function voteAction(Request $request,CheckDroit $checkDroit, Sondage $sondage)
    {
        if($checkDroit->checkDroitProjet($this->getUser()->getIdProprietaire(), $sondage->getIdProjet())) {

            $em = $this->getDoctrine()->getManager();
            $repositoryReponse = $em->getRepository('AppBundle:ReponseSondage');
            $reponse = $repositoryReponse->find($request->get('reponseSondage' . $sondage->getId()));

            $this->getUser()->getIdProprietaire()->addReponse($reponse);
            $em->flush();
            return $this->redirectToRoute('projet_show', array('id' => $sondage->getIdProjet()->getId()));
        }else{
            return $this->redirectToRoute('projet_index');
        }
    }

    /**
     * Displays a form to edit an existing projet entity.
     *
     * @Route("/{id}/edit", name="projet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request,CheckDroit $checkDroit,SendMail $sendMail, Projet $projet)
    {
        if($checkDroit->checkDroitProjet($this->getUser()->getIdProprietaire(), $projet)) {
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

                foreach($projet->getPersonnesConcernees() as $personne) {
                   $sendMail->sendMailEditProjet($personne,$this->getUser()->getIdProprietaire(), $projet);
                }

                return $this->redirectToRoute('projet_show', array('id' => $projet->getId()));
            }

            return $this->render('projet/edit.html.twig', array(
                'projet' => $projet,
                'edit_form' => $editForm->createView(),
            ));
        }else{
            return $this->redirectToRoute('projet_index');
        }
    }

    /**
     * Deletes a projet entity.
     *
     * @Route("/{id}", name="projet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request,CheckDroit $checkDroit, Projet $projet)
    {
        if($checkDroit->checkDroitProjet($this->getUser()->getIdProprietaire(), $projet)) {
            $form = $this->createDeleteForm($projet);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($projet);
                $em->flush();
            }

            return $this->redirectToRoute('projet_index');
        }else{
            return $this->redirectToRoute('projet_index');
        }
    }

}
