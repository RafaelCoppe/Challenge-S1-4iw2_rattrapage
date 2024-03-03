<?php

namespace App\Controller;

use App\Entity\Agency;


use App\Form\AgencyType;
use App\Repository\AgencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/agency', name: 'agency_')]
class AgencyController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(AgencyRepository $agencyRepository): Response
    {
        return $this->render('agency/index.html.twig', [
            'agencies' => $agencyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $agency = new Agency();

        $form = $this->createForm(AgencyType::class, $agency);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($agency);
            $manager->flush();

            $this->addFlash('success', "L'agence {$agency->getName()} a bien été créée");

            return $this->redirectToRoute('agency_show', [
                'id' => $agency->getId()
            ]);
        }

        return $this->render('agency/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}', name: 'show',requirements: ['id' => '\d{1,3}'] ,  methods: ['GET'])]
    public function show(Agency $agency): Response
    {
        return $this->render('agency/show.html.twig', [
            'agency' => $agency,
        ]);
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => '\d{1,3}'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Agency $agency, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AgencyType::class, $agency);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', "L'agence {$agency->getName()} a bien été modifiée");

            return $this->redirectToRoute('agency_index', [
                'id' => $agency->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('agency/update.html.twig', [
            'agency' => $agency,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}/{token}', name: 'delete', requirements: ['id' => '\d{1,3}'], methods: ['GET'])]
    public function delete(Agency $agency, string $token, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $agency->getId(), $token)) {
            $manager->remove($agency);
            $manager->flush();

            $this->addFlash('success', "L'agence {$agency->getName()} a bien été supprimée");
        }

        return $this->redirectToRoute('agency_index');
    }
}
