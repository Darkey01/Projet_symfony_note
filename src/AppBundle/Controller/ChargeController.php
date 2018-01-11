<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Charge;
use AppBundle\Entity\PieceJointe;
use AppBundle\Service\CheckDroit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Charge controller.
 *
 * @Route("/")
 */
class ChargeController extends Controller
{

    /**
     * Lists all charge entities.
     *
     * @Route("proprietaire/charge", name="accueil_proprietaire")
     * @Method("GET")
     */
    public function indexAction()
    {
        $charges = $this->getUser()->getIdProprietaire()->getCharges();

        return $this->render('charge/index.html.twig', array(
            'charges' => $charges,
        ));
    }

    /**
     * Lists all charge entities.
     *
     * @Route("admin/charges", name="listChargeAdmin")
     * @Method("GET")
     */
    public function listChargeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $charges = $em->getRepository('AppBundle:Charge')->findAll();

        return $this->render('charge/index.html.twig', array(
            'charges' => $charges,
        ));
    }

    /**
     * Creates a new charge entity.
     *
     * @Route("admin/charge/new", name="addCharge")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $charge = new Charge();
        $form = $this->createForm('AppBundle\Form\ChargeType', $charge);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if($form['pieceJointe']->getData() != null){
                $pieceJointe = new PieceJointe();
                $pieceJointe->setCharge($charge);
                $dir = 'uploads';
                $file = $form['pieceJointe']->getData();
                $extension = $file->guessExtension();
                if ($extension == 'pdf' || $extension == 'doc' || $extension == 'docx') {
                    $uniqId = uniqid();
                    $file->move($dir, $uniqId . '.' . $extension);
                    $final_url = $dir . '/' . $uniqId . '.' . $extension;
                    $pieceJointe->setChemin($final_url);
                    $pieceJointe->setType("Facture");
                    $pieceJointe->setNom("Facture ".$charge->getTitre());
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($pieceJointe);
                    $charge->setPieceJointe($pieceJointe);
                    $em->flush();
                    $this->addFlash('info', "Piece jointe uploder !");
                }else {
                    $this->addFlash('error', 'Extension invalide');
                }
            }

            $charge->setStatut('A payer');
            foreach($charge->getProprietaires() as $proprietaire){
                $proprietaire->addCharge($charge);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($charge);
            $em->flush();

            return $this->redirectToRoute('listChargeAdmin');
        }

        return $this->render('charge/new.html.twig', array(
            'charge' => $charge,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a charge entity.
     * @Route("admin/charge/{id}", name="charge_admin_show")
     * @Route("proprietaire/charge/{id}", name="charge_proprietaire_show")
     * @Method("GET")
     */
    public function showAction(Charge $charge,CheckDroit $checkDroit)
    {
        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || $checkDroit->checkDroitCharge($this->getUser()->getIdProprietaire(), $charge)) {
            return $this->render('charge/show.html.twig', array(
                'charge' => $charge,
            ));
        }else{
            return $this->redirectToRoute('accueil_proprietaire');
        }
    }

    /**
     * Displays a form to edit an existing charge entity.
     *
     * @Route("/{id}/edit", name="charge_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Charge $charge)
    {
        $editForm = $this->createForm('AppBundle\Form\ChargeType', $charge);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listChargeAdmin', array('id' => $charge->getId()));
        }

        return $this->render('charge/edit.html.twig', array(
            'charge' => $charge,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a charge entity.
     *
     * @Route("/delete/{id}", name="charge_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Charge $charge)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($charge);
        $em->flush();

        return $this->redirectToRoute('listChargeAdmin');
    }

    /**
     * Creates a form to delete a charge entity.
     *
     * @param Charge $charge The charge entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Charge $charge)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('charge_admin_show', array('id' => $charge->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
