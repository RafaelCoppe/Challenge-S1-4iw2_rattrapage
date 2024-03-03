<?php

namespace App\Controller;

use App\Entity\Travelers;
use App\Form\TravelersType;
use App\Repository\InvoiceRepository;
use App\Repository\TravelersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/travelers')]
class TravelersController extends AbstractController
{
    #[Route('/{invoice}', name: 'app_travelers_index', methods: ['GET'])]
    public function index(TravelersRepository $travelersRepository, InvoiceRepository $invoiceRepository, $invoice): Response
    {
        $invoice_object = $invoiceRepository->find($invoice);
        return $this->render('travelers/index.html.twig', [
            'travelers' => $travelersRepository->findBy(["invoice" => $invoice_object]),
            'invoice_id' => $invoice
        ]);
    }

    #[Route('/{invoice}/new', name: 'app_travelers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, InvoiceRepository $invoiceRepository, $invoice): Response
    {
        $traveler = new Travelers();
        $form = $this->createForm(TravelersType::class, $traveler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $traveler->setInvoice($invoiceRepository->find($invoice));
            $entityManager->persist($traveler);
            $entityManager->flush();

            return $this->redirectToRoute('app_travelers_index', [
                'invoice' => $traveler->getInvoice()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('travelers/new.html.twig', [
            'traveler' => $traveler,
            'form' => $form,
            'invoice_id' => $invoice
        ]);
    }

    #[Route('/{id}/show', name: 'app_travelers_show', methods: ['GET'])]
    public function show(Travelers $traveler): Response
    {
        return $this->render('travelers/show.html.twig', [
            'traveler' => $traveler,
            'invoice_id' => $traveler->getInvoice()->getId()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_travelers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Travelers $traveler, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TravelersType::class, $traveler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_travelers_index', [
                'invoice' => $traveler->getInvoice()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('travelers/edit.html.twig', [
            'traveler' => $traveler,
            'form' => $form,
            'invoice_id' => $traveler->getInvoice()->getId()
        ]);
    }

    #[Route('/{id}', name: 'app_travelers_delete', methods: ['POST'])]
    public function delete(Request $request, Travelers $traveler, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$traveler->getId(), $request->request->get('_token'))) {
            $entityManager->remove($traveler);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_travelers_index', [
            'invoice' => $traveler->getInvoice()->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
