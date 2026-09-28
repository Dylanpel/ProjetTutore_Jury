<?php

namespace App\Controller;

use App\Entity\AnneeUser;
use App\Form\AnneeUserType;
use App\Repository\AnneeUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/annee/user')]
final class AnneeUserController extends AbstractController
{
    #[Route(name: 'app_annee_user_index', methods: ['GET'])]
    public function index(AnneeUserRepository $anneeUserRepository): Response
    {
        return $this->render('annee_user/index.html.twig', [
            'annee_users' => $anneeUserRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_annee_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $anneeUser = new AnneeUser();
        $form = $this->createForm(AnneeUserType::class, $anneeUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($anneeUser);
            $entityManager->flush();

            return $this->redirectToRoute('app_annee_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annee_user/new.html.twig', [
            'annee_user' => $anneeUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annee_user_show', methods: ['GET'])]
    public function show(AnneeUser $anneeUser): Response
    {
        return $this->render('annee_user/show.html.twig', [
            'annee_user' => $anneeUser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annee_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AnneeUser $anneeUser, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnneeUserType::class, $anneeUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_annee_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annee_user/edit.html.twig', [
            'annee_user' => $anneeUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annee_user_delete', methods: ['POST'])]
    public function delete(Request $request, AnneeUser $anneeUser, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$anneeUser->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($anneeUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annee_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
