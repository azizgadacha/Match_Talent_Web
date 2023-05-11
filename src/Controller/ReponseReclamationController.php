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
//use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[Route('/reponse/reclamation')]
class ReponseReclamationController extends AbstractController
{

    #[Route('/delete_reponse/{idReponse}', name: 'app_reponse_reclamation_delete_json')]
     public function delete_json(Request $request, $idReponse, NormalizerInterface $normalizer)
   { 
    $em = $this->getDoctrine()->getManager();
    $reponseReclamation =  $em ->getRepository(ReponseReclamation::class)->find($idReponse);
    $em->remove($reponseReclamation);
    $em->flush();

    return new Response("Response deleted successfully.");
}

#[Route('/get_reponse', name: 'app_reponse_reclamation_index_json')]
public function index_json(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
{
    $query = $entityManager->createQuery(
        'SELECT r.idReponse, r.reponse, r.date
         FROM App\Entity\ReponseReclamation r'
    );
    $reclamations = $query->getResult();

    $json = $serializer->serialize($reclamations, 'json');

    return new Response($json, 200, ['Content-Type' => 'application/json']);
}
    //#[Route('/get_reponse', name: 'app_reponse_reclamation_index_json', methods: ['GET'])]
    //public function index_json(ReponseReclamationRepository $reponseReclamationRepository, SerializerInterface $serializer)
    //{
        //$reponseReclamation = $reponseReclamationRepository->findAll();
        //$json = $serializer -> serialize($reponseReclamation, 'json', ['groups' => 'reply'] );
        //return new Response($json);
    //}

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

    #[Route('/post_reponse', name: 'app_reponse_reclamation_new_json')]
    public function new_json(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find(23);
        if(!$reclamation){
            throw $this->createNotFoundException('No Reclamation found for id 20');
        }
        
        $reponseReclamation = new ReponseReclamation;
        $reponseReclamation->setReponse($request->get('reponse'));
        $reponseReclamation->setReclamation($reclamation);
        $em->persist($reponseReclamation);
        $em->flush();
        
        $json = $normalizer->normalize($reponseReclamation, 'json', ['groups' => 'reply']);
        return new Response(json_encode($json));
    }


   #[Route('/add/{idReclamation}', name: 'app_reponse_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, $idReclamation,  ReponseReclamationRepository $reponseReclamationRepository, ReclamationRepository $reclamationRepository): Response
    {
        
        $reponseReclamation = new ReponseReclamation();
        $form = $this->createForm(ReponseReclamationType::class, $reponseReclamation);
        $form->handleRequest($request);
        
       $reclamation =  $reclamationRepository -> find($idReclamation);

       $reponseReclamation -> setReclamation($reclamation);

        if ($form->isSubmitted() && $form->isValid()) {
            $reponseReclamationRepository->save($reponseReclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_reclamation/new.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
            'form' => $form,
        ]);
    }

    /*#[Route('/add/{idReclamation}', name: 'app_reponse_reclamation_new', methods: ['GET', 'POST'])]
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
    }*/
    


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

    #[Route('/showFromRec_reponse/{idReclamation}', name: 'app_reponse_reclamation_show_By_Reclamation_json', methods: ['GET',"POST"])]
public function showByReclamation_json($idReclamation,Request $request,ReponseReclamationRepository $reponseReclamationRepository, ReclamationRepository $reclamationRepository, SerializerInterface $serializer): JsonResponse
{
    $reclamation = $reclamationRepository->find($idReclamation);
    $reponseReclamation = $reponseReclamationRepository->findOneBy(['reclamation'=>$reclamation]);

    if (!$reponseReclamation) {
        return new JsonResponse(['There is no response for this reclamation.'], Response::HTTP_OK);
    }

    $json = $serializer->serialize($reponseReclamation, 'json', ['groups' => 'reply']);

    return new JsonResponse($json, Response::HTTP_OK, [], true);
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

   /* #[Route('/{idReponse}/edit_reponse', name: 'app_reponse_reclamation_edit_json', methods: ['POST'])]
public function edit_json(Request $request, ReponseReclamation $reponseReclamation, ReponseReclamationRepository $reponseReclamationRepository, SerializerInterface $serializer): JsonResponse
{
    $form = $this->createForm(ReponseReclamationType::class, $reponseReclamation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $reponseReclamationRepository->save($reponseReclamation, true);

        $json = $serializer->serialize(['message' => 'ReponseReclamation with ID '.$reponseReclamation->getIdReponse().' has been updated.'], 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    $json = $serializer->serialize($form->getErrors(true, false), 'json');

    return new JsonResponse($json, Response::HTTP_BAD_REQUEST, [], true);
}*/


    #[Route('/{idReponse}', name: 'app_reponse_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, ReponseReclamation $reponseReclamation, ReponseReclamationRepository $reponseReclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponseReclamation->getIdReponse(), $request->request->get('_token'))) {
            $reponseReclamationRepository->remove($reponseReclamation, true);
        }

        return $this->redirectToRoute('app_reponse_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }

    
    

}
