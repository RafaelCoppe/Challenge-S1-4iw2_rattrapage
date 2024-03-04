<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use App\Repository\InvoiceRepository;
use App\Repository\QuotationRepository;
use App\Repository\TravelersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/invoice')]
class InvoiceController extends AbstractController
{
    #[Route('/', name: 'app_invoice_index', methods: ['GET'])]
    public function index(InvoiceRepository $invoiceRepository): Response
    {
        return $this->render('invoice/index.html.twig', [
            'invoices' => $invoiceRepository->findByAgency($this->getUser()->getAgency()->getId()),
        ]);
    }

    #[Route('/new', name: 'app_invoice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, HttpClientInterface $web_client, QuotationRepository $quotation_repository): Response
    {
        $communes = [];
        $response = $web_client->request(
            'GET',
            'https://geo.api.gouv.fr/departements/60/communes/'
        );
        foreach ($response->toArray() as $uneCommune) {
            $cp = $uneCommune['codesPostaux'][0] ?? "";
            $communes["$cp {$uneCommune['nom']}"] = $uneCommune['code'];
        }

        $fullQuotes = $quotation_repository->findQuotesByAgencyAndNoInvoice($this->getUser()->getAgency()->getId());
        $quotes = [];
        foreach ($fullQuotes as $oneQuote) {
            $quotes["{$oneQuote['ref']} - {$oneQuote['terms']}"] = $quotation_repository->find($oneQuote['id']);
        }

        $invoice = new Invoice();
        $form = $this->createForm(InvoiceType::class, $invoice, ["city_choices" => $communes, "quotes_choices" => $quotes]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoice->setPaymentStatus("Non validé");
            $invoice->setStatus("En attente");
            $entityManager->persist($invoice);
            $entityManager->flush();

            return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('invoice/new.html.twig', [
            'invoice' => $invoice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_invoice_show', methods: ['GET'])]
    public function show(TravelersRepository $travelersRepository, Invoice $invoice): Response
    {
        $travelers = $travelersRepository->findBy(["invoice" => $invoice]);
        return $this->render('invoice/show.html.twig', [
            'invoice' => $invoice,
            'travelers' => $travelers,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_invoice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Invoice $invoice, EntityManagerInterface $entityManager, HttpClientInterface $web_client, QuotationRepository $quotation_repository): Response
    {
        $communes = [];
        $response = $web_client->request(
            'GET',
            'https://geo.api.gouv.fr/departements/60/communes/'
        );
        foreach ($response->toArray() as $uneCommune) {
            $cp = $uneCommune['codesPostaux'][0] ?? "";
            $communes["$cp {$uneCommune['nom']}"] = $uneCommune['code'];
        }

        $fullQuotes = $quotation_repository->findBy(['agency' => $this->getUser()->getAgency()]);
        $quotes = [];
        foreach ($fullQuotes as $oneQuote) {
            $quotes["{$oneQuote->getRef()} - {$oneQuote->getTerms()}"] = $quotation_repository->find($oneQuote->getId());
        }

        $form = $this->createForm(InvoiceType::class, $invoice, ["city_choices" => $communes, "quotes_choices" => $quotes]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoice->setPaymentStatus("Non validé");
            $invoice->setStatus("En attente");
            $entityManager->flush();

            return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('invoice/edit.html.twig', [
            'invoice' => $invoice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_invoice_delete', methods: ['POST'])]
    public function delete(Request $request, Invoice $invoice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$invoice->getId(), $request->request->get('_token'))) {
            $entityManager->remove($invoice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/send/{id}", name:"invoice_send", methods: ["POST"])]
    public function send(Request $request, Invoice $invoice, ManagerRegistry $doctrine): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($this->isCsrfTokenValid('send'.$invoice->getId(), $request->request->get('_token'))) {

            $product->setAgency($this->getUser()->getAgency());

            $clientAddress = $request->request->get('client_address');

            $invoiceId = $request->attributes->get('id');

            $entityManager = $doctrine->getManager();

            $response = $this->forward('App\Controller\YourController::mail_send_facture', [
                'quotation_id' => $invoiceId,
                'agency_address' => $this->getUser()->getAgency()->getMail(), 
                'agency_name' => $this->getUser()->getAgency()->getName(), 
                'client_address' => $clientAddress,
            ]);
    
            return $response;

            $invoice->setStatus('Envoyé');
            $doctrine->getManager()->flush();
        }

        

        return $this->redirectToRoute('invoice_index');
    }
}