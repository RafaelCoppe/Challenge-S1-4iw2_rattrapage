<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\Quotation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class InvoiceController extends AbstractController
{
    /*
    *[Route('/invoice', name: 'app_invoice')]
    */
    public function createInvoice(int $quotationId, ManagerRegistry $doctrine): Response
    {
        // Récupérer le devis
        $quotation = $doctrine->getRepository(Quotation::class)->find($quotationId);

        if (!$quotation) {
            throw $this->createNotFoundException('Le devis avec l\'ID ' . $quotationId . ' n\'existe pas.');
        }

        $client = $quotation->getClient();

        $terms = $quotation->getTerms();

        $invoice = new Invoice();

        $invoice->setPaymentLastname($client->getLastName());
        $invoice->setPaymentFirstname($client->getFirstName());
        $invoice->setPaymentPhone($client->getPhone());
        $invoice->setPaymentEmail($client->getEmail());
        $invoice->setPaymentAddress($client->getAddress());
        $invoice->setPaymentCity($client->getCity());

        $terms = $quotation->getTerms();
        $invoice->setTerms($terms);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($invoice);
        $entityManager->flush();

        $quotation->setInvoice($invoice);
        $entityManager->flush();

        return $this->redirectToRoute('quotation_index');
    }

    /**
     * @Route("/invoices", name="invoice_index")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $invoices = $doctrine->getRepository(Invoice::class)->findAll();
        $quotation = $doctrine->getRepository(Quotation::class)->findAll();

        return $this->render('invoice/index.html.twig', [
            'invoices' => $invoices,
            'quotation'  => $quotation,
        ]);
    }
}


//Create avec ttes les données
//Récupérer les terms du devis
//Récupérer l'id du client, pour afficher les données players
//En plus faire le lien entre la facture et le devis pour afficher l'id de la facture dans le devis
