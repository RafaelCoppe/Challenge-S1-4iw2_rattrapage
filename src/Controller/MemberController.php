<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Agency;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/member', name: 'member_')]
class MemberController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(MemberRepository $memberRepository): Response
    {
        return $this->render('member/index.html.twig', [
            'members' => $memberRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $member = new Member();

        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($member);
            $manager->flush();

            $this->addFlash('success', "Le membre {$member->getUsername()} a bien été crée");

            return $this->redirectToRoute('member_show', [
                'id' => $member->getId()
            ]);
        }

        return $this->render('member/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d{1,3}'], methods: ['GET'])]
    public function show(Member $member): Response
    {
        return $this->render('member/show.html.twig', [
            'member' => $member,
        ]);
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => '\d{1,3}'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Member $member, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(MemberType::class, $member);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', "Le membre {$member->getUsername()} a bien été modifié");

            return $this->redirectToRoute('member_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('update.html.twig', [
            'member' => $member,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}/{token}', name: 'delete', methods: ['get'])]
    public function delete(Request $request, Member $member,string $token , EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$member->getId(), $token)) {
            $manager->remove($member);
            $manager->flush();

            $this->addFlash('success', "Le membre {$member->getUsername()} a bien été supprimée");

        }

        return $this->redirectToRoute('member_index');
    }
}
