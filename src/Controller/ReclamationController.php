<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\ReponseReclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Repository\ReponseReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Utilisateur;
use Twig\Environment;


#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(Request $request, ReclamationRepository $reclamationRepository): Response
    {
         // Call the countReclamations method from the repository
        $count = $reclamationRepository->countReclamations();
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
        $maxPerPage = 4;
    
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
            'count' => $count,
        ]);
    }

    //#[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    //public function index(ReclamationRepository $reclamationRepository): Response
    //{
        //return $this->render('reclamation/index.html.twig', [
            //'reclamations' => $reclamationRepository->findAll(),
        //]);
    //}
    #[Route('/statistics', name:'statistics', methods: ['GET'])]
    public function statistics(ReclamationRepository $reclamationRepository, ReponseReclamationRepository $reponseReclamationRepository): JsonResponse
    {
        $reclamationsCount = $reclamationRepository->createQueryBuilder('r')
            ->select('COUNT(r.idReclamation)')
            ->getQuery()
            ->getSingleScalarResult();
    
        $reponsesCount = $reponseReclamationRepository->createQueryBuilder('rr')
            ->select('COUNT(rr.idReponse)')
            ->getQuery()
            ->getSingleScalarResult();
    //The counts of reclamations and reponses are stored in an associative array called $chartData, with keys 'reclamations' and 'responses' respectively.
        $chartData = [
            'reclamations' => $reclamationsCount,
            'responses' => $reponsesCount,
        ];
        //array as a JSON response using the json() method, which is likely provided by the web framework. The array is serialized into JSON format and sent as the response body with appropriate headers indicating that the response contains JSON data.
    
        return $this->json($chartData);
    }
    #[Route('/statistic', name:'statistic', methods: ['GET'])]
public function getReclamationsCount(Request $request, ReclamationRepository $reclamationRepository, ReponseReclamationRepository $reponseReclamationRepository): Response
{
    // Retrieve the Reclamation entity by ID using Doctrine entity manager
    $entityManager = $this->getDoctrine()->getManager();
    //$reclamation = $entityManager->getRepository(Reclamation::class)->find($id);

    // Call the countReclamations method from the repository
    $counttt = $reclamationRepository->countReclamationsNotYet();
    $countttt = $reclamationRepository->countReclamationsDone();
    $count = $reclamationRepository->countReclamations();
    $countt = $reponseReclamationRepository->countReponses();

    // Render the count in a response
    return $this->render('reclamation/statistic.html.twig', [
        'count' => $count,
        'countt' => $countt,
        'counttt' => $counttt,
        'countttt' => $countttt,
    ]);
}

/*#[Route('/my', name: 'app_list', methods: ['GET', 'POST'])]
public function findByDate(string $order = 'DESC'): Response
    {
        // Call the findByDate() method to retrieve sorted reclamation entities
        $reclamations = $this->reclamationRepository->findByDate($order);

        // Pass the sorted entities to the view or perform other actions as needed
        return $this->render('reclamation/list.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }*/
    #[Route('/myy', name: 'app_listt', methods: ['GET', 'POST'])]
    public function my(Request $request, ReclamationRepository $reclamationRepository)
    {
        $order = $request->query->get('order', 'DESC'); // Default order is DESC if not provided
    
        // Query the reclamation data from the database and sort it based on the order
        $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findByDate($order);
    
        // Render the sorted reclamation data to a Twig template
        $html = $this->twig->render('reclamation/list.html.twig', ['reclamations' => $reclamations]);
    
        return new Response($html);
    }
    
    #[Route('/my', name: 'app_list', methods: ['GET', 'POST'])]
    public function list(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/listt.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }
   
 
    #[Route('/status', name: 'app_statut', methods: ['GET', 'POST'])]
    public function status(Request $request, ?string $statut = null): Response
    {
        // Fetch reclamations from the database based on the selected status
        $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findByStatut($statut);
    
        // Fetch the status options for the dropdown menu
        $statusOptions = ['not yet', 'Done']; // Replace with your actual status options
    
        // Render the Twig template with the reclamations and status options
        return $this->render('reclamation/statut.html.twig', [
            'reclamations' => $reclamations,
            'statusOptions' => $statusOptions,
            'selectedStatus' => $statut // Pass the selected status to the Twig template
        ]);
    }
    



    #[Route('/suivi', name: 'app_suivi', methods: ['GET', 'POST'])]
    public function suivi(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/statut.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }
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
            $userReclamation = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['username' => 'hend']);
            $reclamation->setUserReclamation($userReclamation);
    
            $reclamationRepository->save($reclamation, true);
    
            return $this->redirectToRoute('app_reponse_reclamation_index', [], Response::HTTP_SEE_OTHER);
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