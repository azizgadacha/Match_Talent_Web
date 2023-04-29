<?php

namespace App\Controller;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Candidature;
use App\Entity\Postulation;
use App\Entity\Utilisateur;
use App\Form\CandidatureType;
use App\Repository\AnnonceRepository;
use App\Repository\CandidatureRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidature')]
class CandidatureController extends AbstractController
{
    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }


   /* public function searchAction(Request $request,CandidatureRepository $candidatureRepository){
        $data= $request->query->get('search');

        //$query = $em->createQuery(*
           $res= $candidatureRepository->getCandidatureForAnnonceSearch($data);


        return $this->render('FooTransBundle:Default:search.html.twig', array(
            'res' => $res));}*/

    #[Route('/', name: 'app_candidature_index', methods: ['GET'])]
    public function index(CandidatureRepository $candidatureRepository,MailerInterface $mailer): Response

    {


        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidatureRepository->getCandidatureForAnnonce(),
        ]);
    }
    #[Route('/trieNote', name: 'app_candidature_index_trie', methods: ['GET'])]
    public function indextrie(CandidatureRepository $candidatureRepository,MailerInterface $mailer): Response

    {
        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidatureRepository->gettrie(),
        ]);
    }
    #[Route('/trieNom', name: 'app_candidature_index_trie_nom', methods: ['GET'])]
    public function indextrieNom(CandidatureRepository $candidatureRepository,MailerInterface $mailer): Response

    {
        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidatureRepository->gettrieNom(),
        ]);
    }
    #[Route('/admin', name: 'app_candidature_index_admin', methods: ['GET'])]
    public function index_admin(CandidatureRepository $candidatureRepository): Response
    {
        return $this->render('candidature/indexAdmin.html.twig', [
            'candidatures' => $candidatureRepository->getCandidatureForAnnonce(),
        ]);
    }

    #[Route('/new', name: 'app_candidature_new', methods: ['GET', 'POST'])]
    public function new(Request $request,AnnonceRepository $annonceRepository, CandidatureRepository $candidatureRepository): Response
    {
        $candidature = new Candidature();

        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);
        $ut=new Utilisateur(1);

        if ($form->isSubmitted() && $form->isValid()) {
            $ut= $form->getData();
            $candidatureRepository->save($candidature, true);

            return $this->redirectToRoute('app_candidature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidature/new.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
        ]);
    }

    #[Route('/{idCandidature}', name: 'app_candidature_show', methods: ['GET'])]
    public function show(Candidature $candidature): Response
    {
        return $this->render('candidature/show.html.twig', [
            'candidature' => $candidature,
        ]);
    }

    #[Route('/{idCandidature}/edit', name: 'app_candidature_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Candidature $candidature, CandidatureRepository $candidatureRepository): Response
    {
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidatureRepository->save($candidature, true);

            return $this->redirectToRoute('app_candidature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidature/edit.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
        ]);
    }


    #[Route('/delete/{idCandidature}', name: 'app_candidature_delete', methods: ['POST'])]
    public function delete(ManagerRegistry $doctrine,Request $request, Candidature $candidature, CandidatureRepository $candidatureRepository): Response
    {echo "hello";
        //if ($this->isCsrfTokenValid('delete'.$candidature->getIdCandidature(), $request->request->get('_token'))) {
        $entityManager = $doctrine->getManager();
        $postulation = $entityManager->getRepository(Postulation::class)->findOneBy([
            'userPostulation' => $candidature->getUtilisateurAssocier(),
            'annoncePostulation' => $candidature->getAnnonceAssocier(),
        ]);
        $postulation->setEtat('refuser');
        $entityManager->flush();
            $candidatureRepository->remove($candidature, true);
        //}

        return $this->redirectToRoute('app_candidature_index', [], Response::HTTP_SEE_OTHER);
    }
}
