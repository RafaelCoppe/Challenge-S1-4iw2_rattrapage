<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Form\Agency1Type;
use App\Repository\AgencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/agency')]
class AgencyController extends AbstractController
{
    #[Route('/', name: 'app_agency_index', methods: ['GET'])]
    public function index(AgencyRepository $agencyRepository): Response
    {
        return $this->render('agency/index.html.twig', [
            'agencies' => $agencyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_agency_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $agency = new Agency();
        $form = $this->createForm(Agency1Type::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($agency);
            $entityManager->flush();

            return $this->redirectToRoute('app_agency_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('agency/new.html.twig', [
            'agency' => $agency,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agency_show', methods: ['GET'])]
    public function show(Agency $agency): Response
    {
        return $this->render('agency/show.html.twig', [
            'agency' => $agency,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_agency_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Agency $agency, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Agency1Type::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_agency_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('agency/edit.html.twig', [
            'agency' => $agency,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agency_delete', methods: ['POST'])]
    public function delete(Request $request, Agency $agency, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agency->getId(), $request->request->get('_token'))) {
            $entityManager->remove($agency);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_agency_index', [], Response::HTTP_SEE_OTHER);
    }
}
