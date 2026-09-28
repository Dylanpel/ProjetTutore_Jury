<?php

namespace App\Controller;

use App\Entity\NoteGroupe;
use App\Form\NoteGroupeType;
use App\Repository\NoteGroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/note/groupe')]
final class NoteGroupeController extends AbstractController
{
    #[Route(name: 'app_note_groupe_index', methods: ['GET'])]
    public function index(NoteGroupeRepository $noteGroupeRepository): Response
    {
        return $this->render('note_groupe/index.html.twig', [
            'note_groupes' => $noteGroupeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_note_groupe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $noteGroupe = new NoteGroupe();
        $form = $this->createForm(NoteGroupeType::class, $noteGroupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($noteGroupe);
            $entityManager->flush();

            return $this->redirectToRoute('app_note_groupe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note_groupe/new.html.twig', [
            'note_groupe' => $noteGroupe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_note_groupe_show', methods: ['GET'])]
    public function show(NoteGroupe $noteGroupe): Response
    {
        return $this->render('note_groupe/show.html.twig', [
            'note_groupe' => $noteGroupe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_note_groupe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NoteGroupe $noteGroupe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NoteGroupeType::class, $noteGroupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_note_groupe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note_groupe/edit.html.twig', [
            'note_groupe' => $noteGroupe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_note_groupe_delete', methods: ['POST'])]
    public function delete(Request $request, NoteGroupe $noteGroupe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$noteGroupe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($noteGroupe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_note_groupe_index', [], Response::HTTP_SEE_OTHER);
    }
}
