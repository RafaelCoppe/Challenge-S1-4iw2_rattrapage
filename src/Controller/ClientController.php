<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Agency;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Persistence\ManagerRegistry;



#[Route('/client')]
class ClientController extends AbstractController
{



    #[Route('/', name: 'app_client_index', methods: ['GET', 'POST'])]
    public function index(ClientRepository $clientRepository, Request $request, PaginatorInterface $paginator): Response
    {

        $searchTerm = $request->query->get('search');

        // Créez un formulaire de recherche
        $form = $this->createFormBuilder()
            ->add('search', TextType::class, ['required' => false,
            'attr' => [
                'class' => 'w-full border-none bg-transparent px-4 py-1 text-gray-400 outline-none focus:outline-none',
                'placeholder' => 'Search...',
            ],
            'label' => false
            ])
            ->getForm();

        // Si le formulaire est soumis, traitez-le
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez le terme de recherche depuis le formulaire
            $searchTerm = $form->get('search')->getData();

            // Utilisez le terme de recherche pour filtrer les résultats

            $clients = $clientRepository->search($searchTerm, $this->getUser()->getAgency());

        } else {
            // Sinon, récupérez tous les clients qui ont le meme id que le member

            $clients = $clientRepository->findBy(['agency' => $this->getUser()->getAgency()]);

        }

        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findBy(["agency" => $this->getUser()->getAgency()]),
            'form' => $form->createView(), // Passez le formulaire au template
        ]);
    }

    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_show', methods: ['GET'])]
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, Client $client, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();

            // Supprimez d'abord toutes les quotations associées
            foreach ($client->getQuotation() as $quotation) {
                // Supprimez toutes les lignes associées à chaque quotation
                foreach ($quotation->getLines() as $line) {
                    $entityManager->remove($line);
                }
                $entityManager->remove($quotation);
            }
            // Maintenant, supprimez le client
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_client_index');
    }
}
