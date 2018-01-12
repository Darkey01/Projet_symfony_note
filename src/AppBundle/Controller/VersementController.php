<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Charge;
use AppBundle\Entity\PieceJointe;
use AppBundle\Entity\Versement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Versement controller.
 *
 * @Route("charge/versement")
 */
class VersementController extends Controller
{
    /**
     * Lists all versement entities.
     *
     * @Route("/", name="versement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $versements = $em->getRepository('AppBundle:Versement')->findAll();

        return $this->render('versement/index.html.twig', array(
            'versements' => $versements,
        ));
    }

    /**
     * Lists all versement entities.
     *
     * @Route("/", name="versement_proprirtaire_index")
     * @Method("GET")
     */
    public function mesversementAction()
    {
        $versements = $this->getUser()->getIdProprrietaire()->getVersements();

        return $this->render('versement/index.html.twig', array(
            'versements' => $versements,
        ));
    }

    /**
     * Creates a new versement entity.
     *
     * @Route("/{id}/new", name="versement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Charge $charge)
    {
        $versement = new Versement();
        $montanttotprop = $charge->getMontant() / count($charge->getProprietaires());
        $montantpayeprop = 0;
        foreach ($this->getUser()->getIdProprietaire()->getVersements() as $versementUser) {
            if ($versementUser->getChargeLiee() == $charge)
            {
                $montantpayeprop = $montantpayeprop + $versementUser->getMontant();
            }
        }
        $montantmax =  $montanttotprop - $montantpayeprop;
        $form = $this->createForm('AppBundle\Form\VersementType', $versement, array('max' => $montantmax));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $versement->setChargeLiee($charge);

            $versement->setProprietaire($this->getUser()->getIdProprietaire());

            $em = $this->getDoctrine()->getManager();
            $em->persist($versement);
            $em->flush();

            return $this->redirectToRoute('versement_show', array('id' => $versement->getId()));
        }

        return $this->render('versement/new.html.twig', array(
            'versement' => $versement,
            'charge' => $charge,
            'form' => $form->createView(),
        ));
    }



    /**
     * Finds and displays a versement entity.
     *
     * @Route("/{id}", name="versement_show")
     * @Method({"GET","POST"})
     */
    public function showAction(Request $request, Versement $versement)
    {
        $pieceJointe = new PieceJointe();
        $formPc = $this->createForm('AppBundle\Form\PieceJointeType', $pieceJointe);
        $formPc->handleRequest($request);

        if($formPc->isSubmitted() && $formPc->isValid()) {
            $pieceJointe->setVersement($versement);
            $data = $formPc->getData();
            $dir = 'uploads';
            $file = $formPc['chemin']->getData();
            $extension = $file->guessExtension();
            if ($extension == 'pdf' || $extension == 'doc' || $extension == 'docx') {
                $uniqId = uniqid();
                $file->move($dir, $uniqId . '.' . $extension);
                $final_url = $dir . '/' . $uniqId . '.' . $extension;
                $pieceJointe->setChemin($final_url);
                $em = $this->getDoctrine()->getManager();
                $em->persist($pieceJointe);
                $em->flush();
                $this->addFlash('info', "Piece jointe uploder !");
            } else {
                $this->addFlash('error', 'Extension invalide');
            }

        }
        return $this->render('versement/show.html.twig', array(
            'versement' => $versement,
            'formPc' => $formPc->createView()
        ));
    }

    /**
     * Displays a form to edit an existing versement entity.
     *
     * @Route("/{id}/edit", name="versement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Versement $versement)
    {
        $deleteForm = $this->createDeleteForm($versement);
        $editForm = $this->createForm('AppBundle\Form\VersementType', $versement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('versement_edit', array('id' => $versement->getId()));
        }

        return $this->render('versement/edit.html.twig', array(
            'versement' => $versement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a versement entity.
     *
     * @Route("/{id}", name="versement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Versement $versement)
    {
        $form = $this->createDeleteForm($versement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($versement);
            $em->flush();
        }

        return $this->redirectToRoute('versement_index');
    }

    /**
     * Creates a form to delete a versement entity.
     *
     * @param Versement $versement The versement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Versement $versement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('versement_delete', array('id' => $versement->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
