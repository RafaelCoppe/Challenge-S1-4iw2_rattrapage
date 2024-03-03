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
        $invoice->setPaymentStatus('Non validé');
        $invoice->setStatus('En attente');

        $terms = $quotation->getTerms();
        $invoice->setTerms($terms);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($invoice);
        $entityManager->flush();

        $quotation->setInvoice($invoice);
        $entityManager->flush();

        return $this->redirectToRoute('invoice_index');
    }

    /**
     * @Route("/invoices", name="invoice_index")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $invoices = $doctrine->getRepository(Invoice::class)->findAll();
        $quotation = $doctrine->getRepository(Quotation::class)->findAll();
        $user = $this->getUser();

        return $this->render('invoice/index.html.twig', [
            'user' => $user,
            'invoices' => $invoices,
            'quotation'  => $quotation,
        ]);
    }

    /**
     * @Route("/view/{id}", name="invoice_view", methods={"GET"})
     */
    public function view(Invoice $invoice, $id, ManagerRegistry $doctrine): Response
    {
        $invoice = $doctrine->getRepository(Invoice::class)->find($id);

        return $this->render('invoice/view.html.twig', [
            'invoice' => $invoice,
        ]);
    }
}
