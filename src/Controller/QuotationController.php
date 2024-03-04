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
        $quotation->setStatus('Brouillon');
        $quotation->setAgency($this->getUser()->getAgency());
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

        $user = $this->getUser();
        $quotations = $doctrine->getRepository(Quotation::class)->findBy(['agency' => $user->getAgency()]);
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
            // Remove all associated lines first
            foreach ($quotation->getLines() as $line) {
                $entityManager->remove($line);
            }

            // Now remove the quotation

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

    /**
     * @Route("/view/{id}", name="quotation_view", methods={"GET"})
     */
    public function view(Quotation $quotation, $id, ManagerRegistry $doctrine): Response
    {
        $quotation = $doctrine->getRepository(Quotation::class)->find($id);

        $lines = $quotation->getLines()->toArray();

        usort($lines, function ($a, $b) {
            return $a->getPlace() > $b->getPlace();
        });


        return $this->render('quotation/view.html.twig', [
            'quotation' => $quotation,
            'lines' => $lines,
        ]);
    }

    /**
     * @Route("/validate/{id}", name="quotation_validate", methods={"POST"})
     */
    public function validate(Request $request, Quotation $quotation, ManagerRegistry $doctrine): Response
    {
        if ($quotation->getStatus() !== 'En Cours') {
            throw new \LogicException('Le devis ne peut être validé que s\'il est en cours.');
        }

        $quotation->setStatus('Validé');
        $doctrine->getManager()->flush();

        return $this->redirectToRoute('quotation_view', ['id' => $quotation->getId()]);
    }

    /**
     * @Route("/inProgress/{id}", name="quotation_inProgress", methods={"POST"})
     */
    public function inProgress(Request $request, Quotation $quotation, ManagerRegistry $doctrine): Response
    {
        if ($quotation->getStatus() !== 'Validé') {
            throw new \LogicException('Le devis ne peut retourner En cours que s\'il est en validé.');
        }

        $quotation->setStatus('En Cours');
        $doctrine->getManager()->flush();

        return $this->redirectToRoute('quotation_view', ['id' => $quotation->getId()]);
    }
}
