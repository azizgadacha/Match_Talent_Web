<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\PostulationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Candidature;
use App\Entity\Postulation;
use App\Form\CandidatureType;
use App\Repository\AnnonceRepository;
use App\Repository\CandidatureRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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

    #[Route('/admin', name: 'indexadmin_admin_interface', methods: ['GET'])]
    public function index_admin(CandidatureRepository $candidatureRepository): Response
    {

        return $this->render('candidature/indexAdmin.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
        ]);
    }
    #[Route('/{annonceId}', name: 'app_candidature_index', methods: ['GET'])]
    public function index(SerializerInterface $serializerInterface,AnnonceRepository $annonceRepository,$annonceId,CandidatureRepository $candidatureRepository,MailerInterface $mailer): Response

    {
         $annonceRepository->find($annonceId);
        return $this->render('candidature/index.html.twig', [
            'annonceId'=>$annonceId,
            'candidatures' => $candidatureRepository->getCandidatureForAnnonce($annonceId),
        ]);
    }
    #[Route('/mobile/{annonceId}', name: 'app_candidature_index_mobile', methods: ['GET'])]
    public function indexMobile(SerializerInterface $serializerInterface,AnnonceRepository $annonceRepository,$annonceId,CandidatureRepository $candidatureRepository,MailerInterface $mailer)

    {
        $candidatures = $candidatureRepository->findAll();

        $data = [];

        foreach ($candidatures as $candidature) {

            $data[] = [
                'idCandidature' => $candidature->getIdCandidature(),
                'note' => $candidature->getNote(),
                'idAnnonce'=>$candidature->getAnnonceAssocier()->getIdAnnonce(),
                'titre'=>$candidature->getAnnonceAssocier()->getTitre(),
                'Societe'=>$candidature->getAnnonceAssocier()->getSociete(),
                'id'=>$candidature->getUtilisateurAssocier()->getId(),
                'name'=>$candidature->getUtilisateurAssocier()->getName(),
            ];
        }

        return new JsonResponse($data);


      // $serializedata= $serializerInterface->serialize($candidats,'json',['groups'=>"Candiadature,User,Annonce"]);
      //  return new Response(json_encode($serializedata));
    }
  //  #[Route('/trieNote/{annonceId}', name: 'app_candidature_index_trie', methods: ['GET'])]
      #[Route('/trieNote/{annonceId}', name: 'app_candidature_index_trie', methods: ['GET'])]
    public function indextrie($annonceId,CandidatureRepository $candidatureRepository,MailerInterface $mailer): Response

    {
        //            'candidatures' => $candidatureRepository->gettrie(),
        return $this->render('candidature/index.html.twig', [
            'annonceId'=>$annonceId,

            'candidatures' => $candidatureRepository->gettrie($annonceId),
        ]);
    }
    #[Route('/trieNom/{annonceId}', name: 'app_candidature_index_trie_nom', methods: ['GET'])]
    public function indextrieNom($annonceId,CandidatureRepository $candidatureRepository,MailerInterface $mailer): Response

    {
        return $this->render('candidature/index.html.twig', [
            'annonceId'=>$annonceId,

            'candidatures' => $candidatureRepository->gettrieNom($annonceId),
        ]);
    }


    #[Route('/new', name: 'app_candidature_new', methods: ['GET', 'POST'])]
    public function new(Request $request,AnnonceRepository $annonceRepository, CandidatureRepository $candidatureRepository): Response
    {
        $candidature = new Candidature();

        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);
        $ut=new User(1);

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

    #[Route('/show/{idCandidature}/{annonceId}', name: 'app_candidature_show', methods: ['GET'])]
    public function show($annonceId,Candidature $candidature): Response
    {
        return $this->render('candidature/show.html.twig', [
           'annonceId'=>$annonceId,
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

            return $this->redirectToRoute('app_candidature_index', ["id"], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidature/edit.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
        ]);
    }


    #[Route('/delete/{idCandidature}', name: 'app_candidature_delete', methods: ['POST'])]
    public function delete(PostulationRepository $postulationRepository, ManagerRegistry $doctrine,Request $request, Candidature $candidature, CandidatureRepository $candidatureRepository): Response
    {
        //if ($this->isCsrfTokenValid('delete'.$candidature->getIdCandidature(), $request->request->get('_token'))) {
        $entityManager = $doctrine->getManager();
        $postulation = $postulationRepository->findOneBy([
            'userPostulation' => $candidature->getUtilisateurAssocier(),
            'annoncePostulation' => $candidature->getAnnonceAssocier(),
        ]);
        $postulation->setEtat('refuser');
        $entityManager->flush();
            $candidatureRepository->remove($candidature, true);
        //}

        return $this->redirectToRoute('app_candidature_index', ["annonceId"=>$postulation->getAnnoncePostulation()->getIdAnnonce()], Response::HTTP_SEE_OTHER);
    }
    #[Route('/mobile/delete/{idCandidature}', name: 'app_candidature_delete_mobile', methods: ['POST',"GET"])]
    public function deleteMobile(ManagerRegistry $doctrine,Request $request, CandidatureRepository $candidatureRepository): Response
    {
        $candidature= $candidatureRepository->find($request->get("idCandidature"));
        //if ($this->isCsrfTokenValid('delete'.$candidature->getIdCandidature(), $request->request->get('_token'))) {
        $entityManager = $doctrine->getManager();
        //$postulation = $entityManager->getRepository(Postulation::class)->findOneBy([
          //  'userPostulation' => $candidature->getUtilisateurAssocier(),
            //'annoncePostulation' => $candidature->getAnnonceAssocier(),
        //]);
        //$postulation->setEtat('refuser');
        $entityManager->flush();
            $candidatureRepository->remove($candidature, true);
        //}

        return new JsonResponse(["result"=>"succes"]);
    }
}
