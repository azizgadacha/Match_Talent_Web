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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[Route('/reponse/reclamation')]
class ReponseReclamationController extends AbstractController
{

    #[Route('/get_reponse', name: 'app_reponse_reclamation_index_json', methods: ['GET'])]
    public function index_json(ReponseReclamationRepository $reponseReclamationRepository, SerializerInterface $serializer)
    {
        $reponseReclamation = $reponseReclamationRepository->findAll();
        $json = $serializer->serialize($reponseReclamation, 'json', ['groups' => 'reply']);
        return new Response($json);
    }

    #[Route('/post_reponse', name: 'app_reponse_reclamation_new_json')]
    public function new_json(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find(7);
        if (!$reclamation) {
            throw $this->createNotFoundException('No Reclamation found for id 7');
        }

        $reponseReclamation = new ReponseReclamation;
        $reponseReclamation->setReponse($request->get('reponse'));
        $reponseReclamation->setReclamation($reclamation);
        $em->persist($reponseReclamation);
        $em->flush();

        $json = $normalizer->normalize($reponseReclamation, 'json', ['groups' => 'reply']);
        return new Response(json_encode($json));
    }

    #[Route('/showFromRec_reponse/{idReclamation}', name: 'app_reponse_reclamation_show_By_Reclamation_json', methods: ['GET', "POST"])]
    public function showByReclamation_json($idReclamation, Request $request, ReponseReclamationRepository $reponseReclamationRepository, ReclamationRepository $reclamationRepository, SerializerInterface $serializer): JsonResponse
    {
        $reclamation = $reclamationRepository->find($idReclamation);
        $reponseReclamation = $reponseReclamationRepository->findOneBy(['reclamation' => $reclamation]);

        if (!$reponseReclamation) {
            return new JsonResponse(['There is no response for this reclamation.'], Response::HTTP_OK);
        }

        $json = $serializer->serialize($reponseReclamation, 'json', ['groups' => 'reply']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/delete_reponse/{idReponse}', name: 'app_reponse_reclamation_delete_json')]
    public function delete_json(Request $request, $idReponse, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $reponseReclamation = $em->getRepository(ReponseReclamation::class)->find($idReponse);
        $em->remove($reponseReclamation);
        $em->flush();

        return new Response("Response deleted successfully.");
    }
}


