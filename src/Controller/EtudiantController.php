<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/etudiant')]
final class EtudiantController extends AbstractController
{
    #[Route(name: 'app_etudiant_index', methods: ['GET'])]
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        $etudiants = $etudiantRepository->findAll();

        $etudiantData = [];
        foreach($etudiants as $info) {
            $etudiantData[] = ["id"=>$info->getId(), "numero"=>$info->getNumero(), "nom"=>$info->getNom(), "prenom"=>$info->getPrenom(), "remarque"=>$info->getRemarque()];
        }

        return $this->render('etudiant/index.html.twig', [
            "etudiantData" => $etudiantData
        ]);
    }

    #[Route('/new', name: 'app_etudiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etudiant = new Etudiant();
        
        if($request->isMethod('POST')) {
            if(!$this->isCsrfTokenValid('etudiant_form', $request->request->get('_token'))) {
                $this->addFlash('error', "Token invalide");
                return $this->redirectToRoute('app_etudiant_index');
            }

            $etudiant->setNom($request->request->get('nom'));
            $etudiant->setPrenom($request->request->get('prenom'));
            $etudiant->setNumero($request->request->get('numero'));
            $etudiant->setRemarque($request->request->get('remarque'));

            $entityManager->persist($etudiant);
            $entityManager->flush();
            return $this->redirectToRoute('app_etudiant_index');
        }

        $tokenCsrf = $this->container->get('security.csrf.token_manager')->getToken('etudiant_form')->getValue();

        return $this->render('etudiant/new.html.twig', [
            'csrf' => $tokenCsrf
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_show', methods: ['GET'])]
    public function show(Etudiant $etudiant): Response
    {
        $deleteToken = $this->container->get('security.csrf.token_manager')->getToken('delete' . $etudiant->getId())->getValue();

        $etudiantData = ["id"=>$etudiant->getId(), "numero"=>$etudiant->getNumero(), "nom"=>$etudiant->getNom(), "prenom"=>$etudiant->getPrenom(), "remarque"=>$etudiant->getRemarque(), "deleteToken"=>$deleteToken];

        return $this->render('etudiant/show.html.twig', [
            'etudiantData' => $etudiantData
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etudiant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager): Response
    {
        if($request->isMethod('POST')) {
            if(!$this->isCsrfTokenValid('etudiant_form', $request->request->get('_token'))) {
                $this->addFlash('error', "Token invalide");
                return $this->redirectToRoute('app_etudiant_index');
            }

            $etudiant->setNom($request->request->get('nom'));
            $etudiant->setPrenom($request->request->get('prenom'));
            $etudiant->setNumero($request->request->get('numero'));
            $etudiant->setRemarque($request->request->get('remarque'));

            $entityManager->flush();
            return $this->redirectToRoute('app_etudiant_index');
        }

        $tokenCsrf = $this->container->get('security.csrf.token_manager')->getToken('etudiant_form')->getValue();

         $etudiantData = ["id" => $etudiant->getId(), "nom" => $etudiant->getNom(), "prenom" => $etudiant->getPrenom(), "numero" => $etudiant->getNumero(), "remarque" => $etudiant->getRemarque()];

        return $this->render('etudiant/edit.html.twig', [
            'etudiantData' => $etudiantData, 
            'csrf' => $tokenCsrf
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_delete', methods: ['POST'])]
    public function delete(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($etudiant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
    }
}
