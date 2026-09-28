<?php

namespace App\Controller;

use App\Entity\NoteAnnee;
use App\Form\NoteAnneeType;
use App\Repository\NoteAnneeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/note/annee')]
final class NoteAnneeController extends AbstractController
{
    #[Route(name: 'app_note_annee_index', methods: ['GET'])]
    public function index(NoteAnneeRepository $noteAnneeRepository): Response
    {
        return $this->render('note_annee/index.html.twig', [
            'note_annees' => $noteAnneeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_note_annee_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $noteAnnee = new NoteAnnee();
        $form = $this->createForm(NoteAnneeType::class, $noteAnnee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($noteAnnee);
            $entityManager->flush();

            return $this->redirectToRoute('app_note_annee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note_annee/new.html.twig', [
            'note_annee' => $noteAnnee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_note_annee_show', methods: ['GET'])]
    public function show(NoteAnnee $noteAnnee): Response
    {
        return $this->render('note_annee/show.html.twig', [
            'note_annee' => $noteAnnee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_note_annee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NoteAnnee $noteAnnee, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NoteAnneeType::class, $noteAnnee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_note_annee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note_annee/edit.html.twig', [
            'note_annee' => $noteAnnee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_note_annee_delete', methods: ['POST'])]
    public function delete(Request $request, NoteAnnee $noteAnnee, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$noteAnnee->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($noteAnnee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_note_annee_index', [], Response::HTTP_SEE_OTHER);
    }
}
