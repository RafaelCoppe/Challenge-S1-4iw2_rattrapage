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
        $line = new Line();
        $line->setQuote($quotation); 
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
}
