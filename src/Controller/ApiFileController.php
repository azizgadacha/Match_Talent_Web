<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiFileController extends AbstractController
{
    #[Route('/api/file/all', name: 'app_api_file')]
    public function index(NormalizerInterface $normalizer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $file= $em->getRepository(File::class)->findAll();
        $jsonContent = $normalizer->normalize(
            $file,
            'json',
            ['groups' => ['off']]
        );
        // $serializer = new Serializer( [new ObjectNormalizer()]);
        return new JsonResponse($jsonContent);

    }


    #[Route('/api/file/addfile', name: 'addfile')]
    public function addUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $file = new File();
        $em = $this->getDoctrine()->getManager();

        $file->setNamecv($request->get('cv'));
        $file->setNamedeplome($request->get('deplome'));
        $file->setNamemotivation($request->get('motivation'));
        $file->setUserFile($em->getRepository(Utilisateur::class)->find($request->get('user')));

        $entityManager->persist($file);
        $entityManager->flush();

        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize($file);
        return new JsonResponse($formated);
    }



    #[Route('/api/user/modifierfile', name: 'modifierfile')]
    public function modiferfile(Request $request): Response
    {
        $em=$this->getDoctrine()->getManager();
        $file = $em->getRepository(File::class)->find($request->get('id'));
        $file->setFilecv($request->get('cv'));
        $file->setFiledeplome($request->get('deplome'));
        $file->setNamemotivation($request->get('motivation'));
        $em->persist($file);
        $em->flush();

        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize("ok");
        return new JsonResponse($formated);


    }



    #[Route('/api/supprimerfile/{id}', name: 'app_supprimer_file')]
    public function deletefile($id,EntityManagerInterface $entityManager)
    {

        $em=$this->getDoctrine()->getManager();
        $res = $entityManager->getRepository(File::class)
            ->find($id);
        $em->remove($res);
        $em->flush();
        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize("ok");
        return new JsonResponse($formated);
    }







}
