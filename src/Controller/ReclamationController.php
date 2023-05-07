<?php
namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\ReponseReclamation;
use App\Repository\ReclamationRepository;
use App\Repository\ReponseReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Utilisateur;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


#[Route('/reclamation')]
class ReclamationController extends AbstractController
{

    #[Route('/get_reclamation', name: 'app_reclamation_index_json')]
    public function index_json(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $query = $entityManager->createQuery(
            'SELECT r.idReclamation, u.id as id_utilisateur, r.date, r.titre, r.type, r.description, r.statut
         FROM App\Entity\Reclamation r
         JOIN r.userReclamation u'
        );
        $reclamations = $query->getResult();

        $json = $serializer->serialize($reclamations, 'json');

        return new Response($json, 200, ['Content-Type' => 'application/json']);
    }
    #[Route('/post_reclamation', name: 'app_reclamation_new_json')]
    public function new_json(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository(Utilisateur::class)->find(18);
        if(!$utilisateur){
            throw $this->createNotFoundException('No Utilisateur found for id 18');
        }

        $reclamation = new Reclamation;
        $reclamation->setTitre($request->get('titre'));
        $reclamation->setType($request->get('type'));
        $reclamation->setDescription($request->get('description'));
        $reclamation->setUserReclamation($utilisateur);
        $em->persist($reclamation);
        $em->flush();

        $json = $normalizer->normalize($reclamation, 'json', ['groups' => 'reclamations']);
        return new Response(json_encode($json));
    }

    #[Route('/delete_reclamation/{idReclamation}', name: 'app_reclamation_delete_json')]
    public function delete_json(Request $request, $idReclamation, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation =  $em ->getRepository(Reclamation::class)->find($idReclamation);
        $em->remove($reclamation);
        $em->flush();

        return new Response("Reclamation deleted successfully.");
    }

}
