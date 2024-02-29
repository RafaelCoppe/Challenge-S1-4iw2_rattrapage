<?php
// src/Controller/QuotationController.php
namespace App\Controller;

use App\Entity\Quotation;
use App\Form\QuotationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class QuotationController extends AbstractController
{
    /**
     * @Route("/quotation/new", name="quotation_new", methods={"GET","POST"})
     */
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $quotation = new Quotation();
        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($quotation);
            $entityManager->flush();

            return $this->redirectToRoute('quotation_index'); // Rediriger vers une autre page après l'envoi du formulaire
        }

        return $this->render('quotation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/quotation", name="quotation_index")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $quotations = $doctrine->getRepository(Quotation::class)->findAll();

        return $this->render('quotation/index.html.twig', [
            'quotations' => $quotations,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="quotation_delete", methods={"POST"})
     */
    public function delete(Request $request, Quotation $quotation, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quotation->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($quotation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quotation_index');
    }

    /**
     * @Route("/edit/{id}", name="quotation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quotation $quotation, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();

            return $this->redirectToRoute('quotation_index');
        }

        return $this->render('quotation/edit.html.twig', [
            'quotation' => $quotation,
            'form' => $form->createView(),
        ]);
    }
}
