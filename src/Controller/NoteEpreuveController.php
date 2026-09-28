<?php

namespace App\Controller;

use App\Entity\NoteEpreuve;
use App\Form\NoteEpreuveType;
use App\Repository\NoteEpreuveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/note/epreuve')]
final class NoteEpreuveController extends AbstractController
{
    #[Route(name: 'app_note_epreuve_index', methods: ['GET'])]
    public function index(NoteEpreuveRepository $noteEpreuveRepository): Response
    {
        return $this->render('note_epreuve/index.html.twig', [
            'note_epreuves' => $noteEpreuveRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_note_epreuve_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $noteEpreuve = new NoteEpreuve();
        $form = $this->createForm(NoteEpreuveType::class, $noteEpreuve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($noteEpreuve);
            $entityManager->flush();

            return $this->redirectToRoute('app_note_epreuve_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note_epreuve/new.html.twig', [
            'note_epreuve' => $noteEpreuve,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_note_epreuve_show', methods: ['GET'])]
    public function show(NoteEpreuve $noteEpreuve): Response
    {
        return $this->render('note_epreuve/show.html.twig', [
            'note_epreuve' => $noteEpreuve,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_note_epreuve_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NoteEpreuve $noteEpreuve, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NoteEpreuveType::class, $noteEpreuve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_note_epreuve_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note_epreuve/edit.html.twig', [
            'note_epreuve' => $noteEpreuve,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_note_epreuve_delete', methods: ['POST'])]
    public function delete(Request $request, NoteEpreuve $noteEpreuve, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$noteEpreuve->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($noteEpreuve);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_note_epreuve_index', [], Response::HTTP_SEE_OTHER);
    }
}
