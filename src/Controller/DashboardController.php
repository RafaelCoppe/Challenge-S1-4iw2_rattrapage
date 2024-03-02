<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ClientRepository;
use App\Repository\InvoiceRepository;
use App\Repository\QuotationRepository;



class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(InvoiceRepository $invoiceRepository, ClientRepository $clientRepository, QuotationRepository $quotationRepository): Response
    {
        $clients = $clientRepository->findAll();
        $quotationsEnAttente = $quotationRepository->findQuotationsByStatus('En attente');
        $quotations = $quotationRepository->findLatestQuotationsWithClientNames();
        $latestInvoices = $invoiceRepository->findLatestInvoicesWithDetails();
        $totalInvoices = $invoiceRepository->countAllInvoices();

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'clients' => $clients, 
            'quotationsEnAttente' => $quotationsEnAttente,
            'quotations' => $quotations,
            'latestInvoices' => $latestInvoices,
            'totalInvoices' => $totalInvoices,
        ]);
    }
}
