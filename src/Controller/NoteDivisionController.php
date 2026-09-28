<?php

namespace App\Controller;

use App\Entity\NoteDivision;
use App\Form\NoteDivisionType;
use App\Repository\NoteDivisionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/note/division')]
final class NoteDivisionController extends AbstractController
{
    #[Route(name: 'app_note_division_index', methods: ['GET'])]
    public function index(NoteDivisionRepository $noteDivisionRepository): Response
    {
        return $this->render('note_division/index.html.twig', [
            'note_divisions' => $noteDivisionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_note_division_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $noteDivision = new NoteDivision();
        $form = $this->createForm(NoteDivisionType::class, $noteDivision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($noteDivision);
            $entityManager->flush();

            return $this->redirectToRoute('app_note_division_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note_division/new.html.twig', [
            'note_division' => $noteDivision,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_note_division_show', methods: ['GET'])]
    public function show(NoteDivision $noteDivision): Response
    {
        return $this->render('note_division/show.html.twig', [
            'note_division' => $noteDivision,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_note_division_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NoteDivision $noteDivision, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NoteDivisionType::class, $noteDivision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_note_division_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note_division/edit.html.twig', [
            'note_division' => $noteDivision,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_note_division_delete', methods: ['POST'])]
    public function delete(Request $request, NoteDivision $noteDivision, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$noteDivision->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($noteDivision);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_note_division_index', [], Response::HTTP_SEE_OTHER);
    }
}
