<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateurRepository;
use App\Repository\RoleRepository;

#[Route('/annonce')]
class AnnonceController extends AbstractController
{


    #[Route('/', name: 'app_annonce_index', methods: ['GET'])]
    public function index(AnnonceRepository $annonceRepository, UtilisateurRepository $utilisateurRepository, RoleRepository $roleRepository): Response
    {
        $utilisateur = $utilisateurRepository->find(3);
        $role = $utilisateur->getRoleUser();
        $isDemander = $role->getNomRole() === 'DEMANDEUR';


        if ($isDemander) {
          //  $annonces = $annonceRepository->findAllByUtilisateur($utilisateur);
            $annonces = $annonceRepository->findAll();

            return $this->render('annonce/demandeur_index.html.twig', [
                'annonce' => $annonces,
                'isDemander' => true
            ]);
        } else {
            $annonces = $annonceRepository->findAll();


            return $this->render('annonce/index.html.twig', [
                'annonce' => $annonces,
                'isDemander' => false
            ]);
        }
    }






    #[Route('/new', name: 'app_annonce_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnnonceRepository $annonceRepository, UtilisateurRepository $utilisateurRepository, ManagerRegistry $doctrine): Response
    {
        $utilisateur = $utilisateurRepository->find(3);
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em =$doctrine->getManager();
            $annonce->setUtilisateur($utilisateur);

            $annonceRepository->save($annonce, true);

            return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
            
        ]);
          
    }

    #[Route('/{idAnnonce}', name: 'app_annonce_show', methods: ['GET'])]
    public function show(Annonce $annonce): Response
    {
      
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Route('/{idAnnonce}/edit', name: 'app_annonce_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonceRepository->save($annonce, true);

            return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/{idAnnonce}', name: 'app_annonce_delete', methods: ['POST'])]
    public function delete(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getIdAnnonce(), $request->request->get('_token'))) {
            $annonceRepository->remove($annonce, true);
        }

        return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
    }

}
