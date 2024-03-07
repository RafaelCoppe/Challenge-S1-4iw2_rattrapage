<?php

namespace App\Controller;

use App\Entity\Line;
use App\Entity\Quotation;
use App\Form\LineType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class LineController extends AbstractController
{
    /**
     * @Route("/line/create/{quotation_id}", name="line_create", methods={"GET", "POST"})
     */
    public function create(Request $request, int $quotation_id, ManagerRegistry $doctrine): Response
    {
        $quotation = $doctrine->getRepository(Quotation::class)->find($quotation_id);
        $totalLines = count($quotation->getLines());
        $newPlace = $totalLines + 1;

        $line = new Line();
        $line->setQuote($quotation); 
        $line->setPlace($newPlace);

        $form = $this->createForm(LineType::class, $line);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quotation->setStatus('En Cours');
            $entityManager = $doctrine->getManager();
            $entityManager->persist($line);
            $entityManager->flush();

            return $this->redirectToRoute('quotation_view', ['id' => $quotation_id]);
        }

        return $this->render('line/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="line_delete", methods={"POST"})
     */
    public function delete(Request $request, int $quotation_id, int $line_id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $line = $entityManager->getRepository(Line::class)->find($line_id);

        if (!$line) {
            throw $this->createNotFoundException('La ligne avec l\'ID ' . $line_id . ' n\'existe pas.');
        }

        if ($this->isCsrfTokenValid('delete'.$line->getId(), $request->request->get('_token'))) {
            $entityManager->remove($line);
            $entityManager->flush();
        }

        $lines = $entityManager->getRepository(Line::class)->findBy(['quote' => $quotation_id]);
        $place = 1;
        foreach ($lines as $existingLine) {
            $existingLine->setPlace($place++);
            $entityManager->persist($existingLine);
        }
        $entityManager->flush();

        return $this->redirectToRoute('quotation_view', ['id' => $quotation_id]);
    }


    /**
     * @Route("/edit/{id}", name="line_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, int $quotation_id, int $line_id, ManagerRegistry $doctrine): Response
    {
        $line = $doctrine->getRepository(Line::class)->find($line_id);

        if (!$line) {
            throw $this->createNotFoundException('La ligne n\'existe pas');
        }

        $form = $this->createForm(LineType::class, $line);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($line);
            $entityManager->flush();

            return $this->redirectToRoute('quotation_view', ['id' => $quotation_id]);
        }

        return $this->render('line/edit.html.twig', [
            'line' => $line,
            'form' => $form->createView(),
        ]);
    }
}
