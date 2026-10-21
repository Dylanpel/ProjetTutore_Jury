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

        $userData = [];
        foreach ($users as $data) {
            $userData[] = ["id" => $data->getId(),"login" => $data->getLogin(),"roles" => $data->getRoles(),"email" => $data->getEmail(),"remarque" => $data->getRemarque()];
        }

        return $this->render('user/index.html.twig', [
            'userData' => $userData,
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPermissionChecker $userPermission, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $connectedUser = $this->getUser();

        if($request->isMethod('POST')){
             if(!$this->isCsrfTokenValid('user_form', $request->request->get('_token'))){
                $this->addFlash('error', "Token invalide");
                return $this->redirectToRoute('app_user_index');
            }
            $user->setLogin($request->request->get('login'));
            $user->setEmail($request->request->get('email'));
            $user->setRemarque($request->request->get('remarque'));
            $user->setRoles($request->request->all('roles'));
            
            if(!$userPermission->canManage($connectedUser, $user)){
                $this->addFlash('error',"Vous ne pouvez pas créer d'utilsateur avec ce rôle.");
                return $this->redirectToRoute('app_user_index');
            }

            $hashedPassword = $passwordHasher->hashPassword($user, $request->request->get('password'));
            $user->setPassword($hashedPassword);
            
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_user_index');
        }

        $tokenCsrf = $this->container->get('security.csrf.token_manager')->getToken('user_form')->getValue();

        return $this->render('user/new.html.twig', [
            "csrf" => $tokenCsrf
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        $deleteToken = $this->container->get('security.csrf.token_manager')->getToken('delete' . $user->getId())->getValue();

        $userData = ["id" => $user->getId(), "login" => $user->getLogin(), "roles" => $user->getRoles(), "email" => $user->getEmail(), "remarque" => $user->getRemarque(), "deleteToken" => $deleteToken];

        return $this->render('user/show.html.twig', [
            'userData' => $userData,
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

        if($request->isMethod('POST')) {
            if(!$this->isCsrfTokenValid('user_form', $request->request->get('_token'))){
                $this->addFlash('error', "Token invalide");
                return $this->redirectToRoute('app_user_index');
            }
            $user->setLogin($request->request->get('login'));
            $user->setEmail($request->request->get('email'));
            $user->setRemarque($request->request->get('remarque'));
            $user->setRoles($request->request->all('roles'));

            if(!$userPermission->canManage($connectedUser, $user)){
                $this->addFlash('error',"Vous ne pouvez pas attribuer ce rôle à l'utilisateur.");
                return $this->redirectToRoute('app_user_index');
            }

            if(!empty($request->request->get('password'))) {
                 $hashedPassword = $passwordHasher->hashPassword($user, $request->request->get('password'));
                $user->setPassword($hashedPassword);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_user_index');
        }

        $tokenCsrf = $this->container->get('security.csrf.token_manager')->getToken('user_form')->getValue();

        $userData = ["id" => $user->getId(), "login" => $user->getLogin(), "roles" => $user->getRoles(), "email" => $user->getEmail(), "remarque" => $user->getRemarque()];

        return $this->render('user/edit.html.twig', [
            "userData" => $userData,
            "csrf" => $tokenCsrf
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