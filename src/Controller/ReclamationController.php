<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

#[Route('/reclamation')]
class ReclamationController extends AbstractController
{

    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Reclamation::class);
    
        $type = $request->query->get('type');
    
        if ($type) {
            $queryBuilder = $repo->createQueryBuilder('r')
                ->where('r.type = :type')
                ->setParameter('type', $type);
        } else {
            $queryBuilder = $repo->createQueryBuilder('r');
        }
    
        $adapter = new QueryAdapter($queryBuilder);
        $maxPerPage = 5;
    
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($maxPerPage);
    
        $page = $request->query->getInt('page', 1);
        $pagerfanta->setCurrentPage($page);
    
        $reclamations = $pagerfanta->getCurrentPageResults();
    
        $pages = $pagerfanta->getNbPages();
    
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
            'pagerfanta' => $pagerfanta,
            'pages' => $pages,
        ]);
    }


    //#[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    //public function index(ReclamationRepository $reclamationRepository): Response
    //{
        //return $this->render('reclamation/index.html.twig', [
            //'reclamations' => $reclamationRepository->findAll(),
        //]);
    //}

    #[Route('/home', name: 'app_home', methods: ['GET', 'POST'])]
    public function test(): Response
    {
        return $this->renderForm('FrontOffice/index/index.html.twig'
        );
    }


    #[Route('/ajout', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idReclamation}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{idReclamation}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idReclamation}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdReclamation(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
}
