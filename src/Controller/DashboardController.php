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
        $agency_id = $this->getUser()->getAgency()->getId();
        $clients = $clientRepository->findBy(["agency" => $this->getUser()->getAgency()]);
        $quotationsEnAttente = $quotationRepository->findBy(["status" => "en attente"]);
        $quotations = $quotationRepository->findLatestQuotationsWithClientNames($agency_id);
        $latestInvoices = $invoiceRepository->findLatestInvoicesWithDetails($agency_id);
        $totalInvoices = $invoiceRepository->countAllInvoices($agency_id);

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'clients' => $clients, 
            'quotationsEnAttente' => $quotationsEnAttente,
            'quotations' => $quotations,
            'latestInvoices' => $latestInvoices,
            'totalInvoices' => $totalInvoices[0]['count'],
        ]);
    }
}
