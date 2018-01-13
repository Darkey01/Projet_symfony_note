<?php
/**
 * Created by PhpStorm.
 * User: Reynald
 * Date: 13/01/2018
 * Time: 16:20
 */

namespace AppBundle\Service;


use AppBundle\Entity\Charge;
use AppBundle\Entity\PieceJointe;
use AppBundle\Form\FilePathToFileTransformer;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\File;

class UploaderPieceJointe
{

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function upload(PieceJointe $pieceJointe, FormInterface $formPc)
    {

        $dir = 'uploads';
        $file = $formPc['chemin']->getData();
        $extension = $file->guessExtension();
        if ($extension == 'pdf' || $extension == 'doc' || $extension == 'docx') {
            $uniqId = uniqid();
            $file->move($dir, $uniqId . '.' . $extension);
            $final_url = $dir . '/' . $uniqId . '.' . $extension;
            $pieceJointe->setChemin($final_url);
            $em = $this->container->get('doctrine')->getManager();
            $em->persist($pieceJointe);
            $em->flush();

            return true;
        } else {
            return false;
        }

    }

    public function uploadFactureCharge(PieceJointe $pieceJointe, FormInterface $formPc, $titre)
    {
        $dir = 'uploads';
        $file = $formPc['pieceJointe']->getData();
        $extension = $file->guessExtension();
        if ($extension == 'pdf' || $extension == 'doc' || $extension == 'docx') {
            $uniqId = uniqid();
            $file->move($dir, $uniqId . '.' . $extension);
            $final_url = $dir . '/' . $uniqId . '.' . $extension;
            $pieceJointe->setChemin($final_url);
            $pieceJointe->setType("Facture");
            $pieceJointe->setNom("Facture ".$titre);
            return $pieceJointe;
        } else {
            return null;
        }
    }

    public function uploadEditFactureCharge(PieceJointe $pieceJointe, FormInterface $formPc,  $titre)
    {
        $dir = 'uploads';
        $tmp_dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
        $uploadedFilePath = $tmp_dir.'/'.$formPc['pieceJointe']->getData();
        $file = new File($uploadedFilePath);
        $extension = $file->guessExtension();
        if ($extension == 'pdf' || $extension == 'doc' || $extension == 'docx') {
            $uniqId = uniqid();
            $file->move($dir, $uniqId . '.' . $extension);
            $final_url = $dir . '/' . $uniqId . '.' . $extension;
            $pieceJointe->setChemin($final_url);
            $pieceJointe->setType("Facture");
            $pieceJointe->setNom("Facture ".$titre);
            return $pieceJointe;
        } else {
            return null;
        }

    }


}