<?php

namespace App\Controller;

use App\Entity\Annonce;
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

    #[Route('/new', name: 'app_rendez_vous_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine,RendezVousRepository $rendezVousRepository, AnnonceRepository $annonceRepository,CandidatureRepository $candidatureRepository): Response
    {
        $idCandidature = $request->query->get('idCandidature');
        $Candidature= $candidatureRepository->find($idCandidature);
        $rendezVou = new RendezVous();
       $id= $Candidature->getUtilisateurAssocier()->getId();
       $utilisateur= $Candidature->getUtilisateurAssocier();
       $annonce= $Candidature->getAnnonceAssocier();
       $id5= $Candidature->getAnnonceAssocier()->getIdAnnonce();
       echo "tes1";
       echo "test3 ".$id."sssssss".$id5;
       $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em=$doctrine->getManager();

            echo "te";
            echo "teuu ".$id."sssssss".$id5;
            $rendezVou->setAnnonce($annonce);
            $rendezVou->setUserRendezVous($utilisateur);
 echo "qqqqq".$rendezVou->getAnnonce()->getIdAnnonce();
            $em->persist($rendezVou);
            $em->flush();

          //  $rendezVousRepository->save();
            //save($rendezVou, true);

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
            'rendez_vou' => $rendezVou,
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
    public function delete(Request $request, RendezVous $rendezVou, RendezVousRepository $rendezVousRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezVou->getIdRendezVous(), $request->request->get('_token'))) {
            $rendezVousRepository->remove($rendezVou, true);
        }

        return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
    }
}
