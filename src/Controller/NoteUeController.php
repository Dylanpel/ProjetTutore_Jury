<?php

namespace App\Controller;

use App\Entity\NoteUe;
use App\Form\NoteUeType;
use App\Repository\NoteUeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/note/ue')]
final class NoteUeController extends AbstractController
{
    #[Route(name: 'app_note_ue_index', methods: ['GET'])]
    public function index(NoteUeRepository $noteUeRepository): Response
    {
        return $this->render('note_ue/index.html.twig', [
            'note_ues' => $noteUeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_note_ue_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $noteUe = new NoteUe();
        $form = $this->createForm(NoteUeType::class, $noteUe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($noteUe);
            $entityManager->flush();

            return $this->redirectToRoute('app_note_ue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note_ue/new.html.twig', [
            'note_ue' => $noteUe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_note_ue_show', methods: ['GET'])]
    public function show(NoteUe $noteUe): Response
    {
        return $this->render('note_ue/show.html.twig', [
            'note_ue' => $noteUe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_note_ue_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NoteUe $noteUe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NoteUeType::class, $noteUe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_note_ue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note_ue/edit.html.twig', [
            'note_ue' => $noteUe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_note_ue_delete', methods: ['POST'])]
    public function delete(Request $request, NoteUe $noteUe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$noteUe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($noteUe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_note_ue_index', [], Response::HTTP_SEE_OTHER);
    }
}
