<?php

namespace App\Controller;

use App\Entity\Ue;
use App\Form\UeType;
use App\Repository\UeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ue')]
final class UeController extends AbstractController
{
    #[Route(name: 'app_ue_index', methods: ['GET'])]
    public function index(UeRepository $ueRepository): Response
    {
        return $this->render('ue/index.html.twig', [
            'ues' => $ueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ue_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ue = new Ue();
        $form = $this->createForm(UeType::class, $ue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ue);
            $entityManager->flush();

            return $this->redirectToRoute('app_ue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ue/new.html.twig', [
            'ue' => $ue,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ue_show', methods: ['GET'])]
    public function show(Ue $ue): Response
    {
        return $this->render('ue/show.html.twig', [
            'ue' => $ue,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ue_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ue $ue, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UeType::class, $ue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ue/edit.html.twig', [
            'ue' => $ue,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ue_delete', methods: ['POST'])]
    public function delete(Request $request, Ue $ue, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ue->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ue_index', [], Response::HTTP_SEE_OTHER);
    }
}
