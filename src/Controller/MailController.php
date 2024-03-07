<?php

namespace App\Controller;

use App\Repository\QuotationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/mail')]
class MailController extends AbstractController
{
    CONST footer = "<br><br>Pour toute réclamation, merci d'envoyer un mail à 'contact@devisio.site'";
    #[Route('/contact', name: 'mail_contact')]
    public function mail_contact(MailerInterface $mailer): Response
    {
        $contact_name = $_POST['name'] . ' ' . $_POST['firstname'];

        $email = (new Email())
            ->from(new Address($_POST['email'], "Rafael COPPE"))
            ->to(new Address('contact@devisio.site'))
            ->subject('Nouveau mail de contact de : ' . $_POST['civilite'] . ' ' . $contact_name . ' (' . $_POST["email"] . ' / ' . $_POST["phone"] . ')')
            ->html('Nouveau mail de contact de : ' . $_POST['civilite'] . ' ' . $contact_name . ' (' . $_POST["email"] . ' / ' . $_POST["phone"] . ')<br><br>' . $_POST["message"] . '<br><br>Envoyé via le formulaire de contact');

        $mailer->send($email);

        return $this->render('_composants/contact.html.twig');
    }

    #[Route('/devis', name: 'mail_valid_devis')]
    public function mail_valid_devis(MailerInterface $mailer, $quotation_id, $agency_address, $agency_name, $client_address): Response
    {
        $response = $this->forward('App\Controller\PdfController::index', array(
            'id'  => $quotation_id,
            'facture' => '0',
            'return_titre' => '1',
        ));
        $devis_link = json_decode($response->getContent());

        $email = (new Email())
            ->from(new Address($agency_address, $agency_name))
            ->to(new Address($client_address))
            ->subject('Devis de voyage validé par l\'agence "' . $agency_name . '"')
            ->html('L\'agence "' . $agency_name . '" a validé un devis de voyage qui vous est adressé. Vous pouvez retrouver ce devis en pièce jointe.<br>
                Vous recevrez la facture par mail prochainement' . self::footer)
            ->addPart(new DataPart(new File($devis_link, $devis_link)));

        $mailer->send($email);
        unlink($devis_link);

        return $this->render('default/index.html.twig', ['controller_name' => "mailController"]);
    }

    #[Route('/facture', name: 'mail_send_facture')]
    public function mail_send_facture(MailerInterface $mailer, $quotation_id, $agency_address, $agency_name, $client_address): Response
    {
        $response = $this->forward('App\Controller\PdfController::index', array(
            'id'  => $quotation_id,
            'facture' => '1',
            'return_titre' => '1',
        ));
        $devis_link = json_decode($response->getContent());

        $email = (new Email())
            ->from(new Address($agency_address, $agency_name))
            ->to(new Address($client_address))
            ->subject('Facture définitive de votre voyage par l\'agence "' . $agency_name . '"')
            ->html('L\'agence "' . $agency_name . '" vous transmet la facture de votre voyage. Vous pouvez la retrouver en pièce jointe<br>' . self::footer)
            ->addPart(new DataPart(new File($devis_link, $devis_link)));

        $mailer->send($email);
        unlink($devis_link);

        return $this->render('default/index.html.twig', ['controller_name' => "mailController"]);
    }
}
