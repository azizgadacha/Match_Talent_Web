<?php

namespace App\Controller;

use App\Entity\ReponseReclamation;
use App\Entity\Reclamation;
use App\Form\ReponseReclamationType;
use App\Repository\ReponseReclamationRepository;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/reponse/reclamation')]
class ReponseReclamationController extends AbstractController
{

    #[Route('/json_findall_rep', name: 'app_reponse_reclamation_index_json', methods: ['GET'])]
    public function index_json(ReponseReclamationRepository $reponseReclamationRepository): JsonResponse
    {
        $reponseReclamation = $reponseReclamationRepository->findAll();
    
        return $this->json([
            'reponse_reclamation' => $reponseReclamation,
        ]);
    }

    #[Route('/', name: 'app_reponse_reclamation_index', methods: ['GET'])]
    public function index(ReponseReclamationRepository $reponseReclamationRepository): Response
    {
        return $this->render('reponse_reclamation/index.html.twig', [
            'reponse_reclamations' => $reponseReclamationRepository->findAll(),
        ]);
    }

    #[Route('/Not yet', name: 'app_reponse', methods: ['GET'])]
    public function notyet(ReponseReclamationRepository $reponseReclamationRepository): Response
    {
        return $this->render('reponse_reclamation/notyet.html.twig');
    }

   /*#[Route('/add', name: 'app_reponse_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReponseReclamationRepository $reponseReclamationRepository): Response
    {
        $reponseReclamation = new ReponseReclamation();
        $form = $this->createForm(ReponseReclamationType::class, $reponseReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reponseReclamationRepository->save($reponseReclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_reclamation/new.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
            'form' => $form,
        ]);
    }*/

    #[Route('/add/{idReclamation}', name: 'app_reponse_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReponseReclamationRepository $reponseReclamationRepository, $idReclamation): Response
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($idReclamation);
        if (!$reclamation) {
            throw $this->createNotFoundException('The reclamation does not exist');
        }
    
        $reponseReclamation = new ReponseReclamation();
        $reponseReclamation->setReclamation($reclamation);
    
        $form = $this->createForm(ReponseReclamationType::class, $reponseReclamation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $reponseReclamationRepository->save($reponseReclamation, true);
    
            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('reponse_reclamation/new.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
            'form' => $form,
        ]);
    }
    


    #[Route('/{idReponse}', name: 'app_reponse_reclamation_show', methods: ['GET'])]
    public function show(ReponseReclamation $reponseReclamation): Response
    {
        return $this->render('reponse_reclamation/show.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
        ]);
    } 
    #[Route('/showFromRec/{idReclamation}', name: 'app_reponse_reclamation_show_By_Reclamation', methods: ['GET',"POST"])]
    public function showByReclamation($idReclamation,Request $request,ReponseReclamationRepository $reponseReclamationRepository, ReclamationRepository $reclamationRepository): Response
    {
        //$idReclamation = $request->query->get('idReclamation');
       // echo "nemchi ".$idReclamation." hatt ena";
        $reclamation= $reclamationRepository->find($idReclamation);
$reponseReclamation=$reponseReclamationRepository->findOneBy(['reclamation'=>$reclamation]);
if (!$reponseReclamation) {
    // Redirect to "no reponse yet" page
    return $this->redirectToRoute('app_reponse', [], Response::HTTP_SEE_OTHER);
}
       return $this->render('reponse_reclamation/show.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
        ]);
    }

    #[Route('/{idReponse}/edit', name: 'app_reponse_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReponseReclamation $reponseReclamation, ReponseReclamationRepository $reponseReclamationRepository): Response
    {
        $form = $this->createForm(ReponseReclamationType::class, $reponseReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reponseReclamationRepository->save($reponseReclamation, true);

            return $this->redirectToRoute('app_reponse_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_reclamation/edit.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idReponse}', name: 'app_reponse_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, ReponseReclamation $reponseReclamation, ReponseReclamationRepository $reponseReclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponseReclamation->getIdReponse(), $request->request->get('_token'))) {
            $reponseReclamationRepository->remove($reponseReclamation, true);
        }

        return $this->redirectToRoute('app_reponse_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
}