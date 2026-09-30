<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\UserPermissionChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route(name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, UserPermissionChecker $userPermission): Response
    {
        
        $connectedUser = $this->getUser();

        $users = array_filter(
            $userRepository->findAll(),
            fn (User $user) => $userPermission->canSee($connectedUser, $user)
        );

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPermissionChecker $userPermission, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $connectedUser = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$userPermission->canManage($connectedUser, $user)) {
                $this->addFlash('error', "Vous ne pouvez pas créer d'utilisateurs avec ce rôle.");

                return $this->redirectToRoute('app_user_index');
            }

            $plainPassword = $form->get('password')->getData();
            if (!$plainPassword) {
                $form->get('password')->addError(new FormError('Le mot de passe est obligatoire.'));

                return $this->render('user/new.html.twig', [
                    'user' => $user,
                    'form' => $form,
                ]);
            }
            $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPermissionChecker $userPermission, UserPasswordHasherInterface $passwordHasher): Response
    {
        $connectedUser = $this->getUser();

        
        if (!$userPermission->canManage($connectedUser, $user)) {
            $this->addFlash('error', "Vous ne pouvez pas modifier ce profil !");

            return $this->redirectToRoute('app_user_index');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            if (!$userPermission->canManage($connectedUser, $user)) {
                $this->addFlash('error', "Vous ne pouvez pas attribuer ce rôle !");

                return $this->redirectToRoute('app_user_index');
            }

            $plainPassword = $form->get('password')->getData();
            if ($plainPassword) {
                $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager, UserPermissionChecker $userPermission): Response
    {
        $connectedUser = $this->getUser();

        if (!$userPermission->canDelete($connectedUser, $user)) {
            $this->addFlash('error', "Vous n'avez pas le droit de supprimer cet utilisateur.");

            return $this->redirectToRoute('app_user_index');
        }

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}