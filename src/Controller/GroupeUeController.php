<?php

namespace App\Controller;

use App\Entity\GroupeUe;
use App\Form\GroupeUeType;
use App\Repository\GroupeUeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/groupe/ue')]
final class GroupeUeController extends AbstractController
{
    #[Route(name: 'app_groupe_ue_index', methods: ['GET'])]
    public function index(GroupeUeRepository $groupeUeRepository): Response
    {
        return $this->render('groupe_ue/index.html.twig', [
            'groupe_ues' => $groupeUeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_groupe_ue_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $groupeUe = new GroupeUe();
        $form = $this->createForm(GroupeUeType::class, $groupeUe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($groupeUe);
            $entityManager->flush();

            return $this->redirectToRoute('app_groupe_ue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('groupe_ue/new.html.twig', [
            'groupe_ue' => $groupeUe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_groupe_ue_show', methods: ['GET'])]
    public function show(GroupeUe $groupeUe): Response
    {
        return $this->render('groupe_ue/show.html.twig', [
            'groupe_ue' => $groupeUe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_groupe_ue_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GroupeUe $groupeUe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GroupeUeType::class, $groupeUe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_groupe_ue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('groupe_ue/edit.html.twig', [
            'groupe_ue' => $groupeUe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_groupe_ue_delete', methods: ['POST'])]
    public function delete(Request $request, GroupeUe $groupeUe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupeUe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($groupeUe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_groupe_ue_index', [], Response::HTTP_SEE_OTHER);
    }
}
