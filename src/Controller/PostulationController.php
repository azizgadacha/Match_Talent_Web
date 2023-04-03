<?php

namespace App\Controller;

use App\Entity\Postulation;
use App\Form\PostulationType;
use App\Repository\PostulationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/postulation')]
class PostulationController extends AbstractController
{
    #[Route('/', name: 'app_postulation_index', methods: ['GET'])]
    public function index(PostulationRepository $postulationRepository): Response
    {
        return $this->render('postulation/index.html.twig', [
            'postulations' => $postulationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_postulation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostulationRepository $postulationRepository): Response
    {
        $postulation = new Postulation();
        $form = $this->createForm(PostulationType::class, $postulation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postulationRepository->save($postulation, true);

            return $this->redirectToRoute('app_postulation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('postulation/new.html.twig', [
            'postulation' => $postulation,
            'form' => $form,
        ]);
    }

    #[Route('/{annoncePostulation}', name: 'app_postulation_show', methods: ['GET'])]
    public function show(Postulation $postulation): Response
    {
        return $this->render('postulation/show.html.twig', [
            'postulation' => $postulation,
        ]);
    }

    #[Route('/{annoncePostulation}/edit', name: 'app_postulation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Postulation $postulation, PostulationRepository $postulationRepository): Response
    {
        $form = $this->createForm(PostulationType::class, $postulation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postulationRepository->save($postulation, true);

            return $this->redirectToRoute('app_postulation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('postulation/edit.html.twig', [
            'postulation' => $postulation,
            'form' => $form,
        ]);
    }

    #[Route('/{annoncePostulation}', name: 'app_postulation_delete', methods: ['POST'])]
    public function delete(Request $request, Postulation $postulation, PostulationRepository $postulationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postulation->getAnnoncePostulation(), $request->request->get('_token'))) {
            $postulationRepository->remove($postulation, true);
        }

        return $this->redirectToRoute('app_postulation_index', [], Response::HTTP_SEE_OTHER);
    }
}
