<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Postulation;
use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\AnnonceRepository;
use App\Repository\CandidatureRepository;
use App\Repository\RendezVousRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rendez/vous')]
class RendezVousController extends AbstractController
{
    #[Route('/', name: 'app_rendez_vous_index', methods: ['GET'])]
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        return $this->render('rendez_vous/index.html.twig', [
            'rendez_vouses' => $rendezVousRepository->findAll(),
        ]);
    }
    #[Route('/admin', name: 'app_admin_rendez_vous_index', methods: ['GET'])]
    public function indexAdmin(RendezVousRepository $rendezVousRepository): Response
    {
        return $this->render('rendez_vous/indexAdmin.html.twig', [
            'rendez_vouses' => $rendezVousRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rendez_vous_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine,RendezVousRepository $rendezVousRepository, AnnonceRepository $annonceRepository,CandidatureRepository $candidatureRepository): Response
    {
        $idCandidature = $request->query->get('idCandidature');
        $Candidature= $candidatureRepository->find($idCandidature);
        $rendezVou = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $postulation = $entityManager->getRepository(Postulation::class)->findOneBy([
                'userPostulation' => $Candidature->getUtilisateurAssocier(),
                'annoncePostulation' => $Candidature->getAnnonceAssocier(),
            ]);
             // Update the entity properties
                $postulation->setEtat('accepter');
                $entityManager->flush();
            $rendezVou->setUserRendezVous($Candidature->getUtilisateurAssocier());
            $rendezVou->setAnnonceAssocierRendezVous($Candidature->getAnnonceAssocier());
            $rendezVousRepository->save($rendezVou,true);
            return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendez_vous/new.html.twig', [
            'rendez_vou' => $rendezVou,
            "candidature"=>$Candidature,
            'form' => $form,
        ]);
    }

    #[Route('/{idRendezVous}', name: 'app_rendez_vous_show', methods: ['GET'])]
    public function show(RendezVous $rendezVou): Response
    {
        return $this->render('rendez_vous/show.html.twig', [
            'rendez_vous' => $rendezVou,
        ]);
    }

    #[Route('/{idRendezVous}/edit', name: 'app_rendez_vous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RendezVous $rendezVou, RendezVousRepository $rendezVousRepository): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $rendezVousRepository->save($rendezVou, true);

            return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('rendez_vous/edit.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{idRendezVous}', name: 'app_rendez_vous_delete', methods: ['POST'])]
    public function delete(Request $request,ManagerRegistry $doctrine, RendezVous $rendezVou, RendezVousRepository $rendezVousRepository): Response
    {
        $entityManager = $doctrine->getManager();
        $postulation = $entityManager->getRepository(Postulation::class)->findOneBy([
            'userPostulation' => $rendezVou->getUserRendezVous(),
            'annoncePostulation' => $rendezVou->getAnnonceAssocierRendezVous(),
        ]);
        // Update the entity properties
        $postulation->setEtat('refuser');
        $entityManager->flush();
       // if ($this->isCsrfTokenValid('delete'.$rendezVou->getIdRendezVous(), $request->request->get('_token'))) {
            $rendezVousRepository->remove($rendezVou, true);
     //   }

        return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
    }
}
