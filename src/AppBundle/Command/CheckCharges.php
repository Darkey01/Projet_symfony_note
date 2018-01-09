<?php
/**
 * Created by PhpStorm.
 * User: Reynald
 * Date: 20/12/2017
 * Time: 21:56
 */
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Validator\Constraints\DateTime;

class CheckCharges extends ContainerAwareCommand
{

    protected function configure()
    {

        $this
            ->setName("AppBundle:CheckCharge")
            ->setDescription('Check date of charge.');
    }


    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
// $doctrine=$this->container->get('doctrine');
        $output->writeln("Recherche charge en cours");
        $chargeRepository = $this->getContainer()->get('doctrine')->getRepository('AppBundle:Charge');
        $charges = $chargeRepository->findAll();
        $chargeDateDepasse = array();
        $message_txt = "Voici la liste des tâches de la co-propriétée impayées et dont la date est arrivée à échéance : ";
        foreach ($charges as $charge) {
            $dateNow = new \DateTime("NOW");

            if ($charge->getStatut() != "Paye" && $charge->getDateEcheance() < $dateNow) {
                $output->writeln($charge->getTitre());
                $message_txt = $message_txt . $charge->getTitre() . " ,";
                array_push($chargeDateDepasse, $charge);
            }
        }
        if (sizeof($chargeDateDepasse) > 0) {
            $mail = 'test@yopmail.fr'; // Déclaration de l'adresse de destination.
            if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
                $passage_ligne = "\r\n";
            } else {
                $passage_ligne = "\n";
            }

            $boundary = "-----=" . md5(rand());
            $sujet = "Charges impayé Co-Propriété !";
            $header = "From: \"reynald\"<reynald@yopmail.fr>" . $passage_ligne;
            $header .= "Reply-to: \"reynald\" <reynald@yopmail.fr>" . $passage_ligne;
            $header .= "MIME-Version: 1.0" . $passage_ligne;
            $header .= "Content-Type: multipart/alternative;" . $passage_ligne . " boundary=\"$boundary\"" . $passage_ligne;

            $message = $passage_ligne . "--" . $boundary . $passage_ligne;
            $message .= "Content-Type: text/plain; charset=\"ISO-8859-1\"" . $passage_ligne;
            $message .= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
            $message .= $passage_ligne . $message_txt . $passage_ligne;
            $message .= $passage_ligne . "--" . $boundary . $passage_ligne;
            $message .= $passage_ligne . "--" . $boundary . "--" . $passage_ligne;
            $message .= $passage_ligne . "--" . $boundary . "--" . $passage_ligne;
            mail($mail, $sujet, $message, $header);


        }

    }
}