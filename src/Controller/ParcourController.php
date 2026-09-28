<?php

namespace App\Controller;

use App\Entity\Parcour;
use App\Form\ParcourType;
use App\Repository\ParcourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/parcour')]
final class ParcourController extends AbstractController
{
    #[Route(name: 'app_parcour_index', methods: ['GET'])]
    public function index(ParcourRepository $parcourRepository): Response
    {
        return $this->render('parcour/index.html.twig', [
            'parcours' => $parcourRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_parcour_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parcour = new Parcour();
        $form = $this->createForm(ParcourType::class, $parcour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($parcour);
            $entityManager->flush();

            return $this->redirectToRoute('app_parcour_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('parcour/new.html.twig', [
            'parcour' => $parcour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parcour_show', methods: ['GET'])]
    public function show(Parcour $parcour): Response
    {
        return $this->render('parcour/show.html.twig', [
            'parcour' => $parcour,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parcour_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parcour $parcour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParcourType::class, $parcour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_parcour_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('parcour/edit.html.twig', [
            'parcour' => $parcour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parcour_delete', methods: ['POST'])]
    public function delete(Request $request, Parcour $parcour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parcour->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($parcour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parcour_index', [], Response::HTTP_SEE_OTHER);
    }
}
