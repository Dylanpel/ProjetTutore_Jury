<?php

namespace App\Controller;

use App\Entity\Mention;
use App\Form\MentionType;
use App\Repository\MentionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mention')]
final class MentionController extends AbstractController
{
    #[Route(name: 'app_mention_index', methods: ['GET'])]
    public function index(MentionRepository $mentionRepository): Response
    {
        return $this->render('mention/index.html.twig', [
            'mentions' => $mentionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mention_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mention = new Mention();
        $form = $this->createForm(MentionType::class, $mention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mention);
            $entityManager->flush();

            return $this->redirectToRoute('app_mention_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mention/new.html.twig', [
            'mention' => $mention,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mention_show', methods: ['GET'])]
    public function show(Mention $mention): Response
    {
        return $this->render('mention/show.html.twig', [
            'mention' => $mention,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mention_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mention $mention, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MentionType::class, $mention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mention_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mention/edit.html.twig', [
            'mention' => $mention,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mention_delete', methods: ['POST'])]
    public function delete(Request $request, Mention $mention, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mention->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($mention);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mention_index', [], Response::HTTP_SEE_OTHER);
    }
}
