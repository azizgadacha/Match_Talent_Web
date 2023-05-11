<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\File;
use App\Entity\Postulation;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiPostulationController extends AbstractController
{

    #[Route('/api/postulation', name: 'app_api_postulationuser')]
    public function index(NormalizerInterface $normalizer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $file= $em->getRepository(Postulation::class)->findAll();
        $jsonContent = $normalizer->normalize(
            $file,
            'json',
            ['groups' => ['postulation']]
        );        // $serializer = new Serializer( [new ObjectNormalizer()]);
        return new JsonResponse($jsonContent);

    }


    #[Route('/api/postulation/all', name: 'app_api_postulation')]
    public function postulationAll(NormalizerInterface $normalizer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Utilisateur::class)->find(6);
        $file= $em->getRepository(Postulation::class)->findAll();
        $jsonContent = $normalizer->normalize($file,'json');
        // $serializer = new Serializer( [new ObjectNormalizer()]);
        return new JsonResponse($jsonContent);

    }

    #[Route('/api/annonce/all', name: 'app_api_annonce')]
    public function annonceAll(NormalizerInterface $normalizer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $file= $em->getRepository(Annonce::class)->findAll();
        $jsonContent = $normalizer->normalize(
            $file,
            'json',
            ['groups' => ['ann']]
        );
        // $serializer = new Serializer( [new ObjectNormalizer()]);
        return new JsonResponse($jsonContent);

    }




    #[Route('/api/postulation/addpostulation', name: 'addpostulation')]
    public function addPostulation(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $file = new Postulation();
        $em = $this->getDoctrine()->getManager();

        $file->setEtat("en cours");
        $file->setDate(new \DateTime());
       // $file->setFileAssocier($em->getRepository(File::class)->find($request->get('file')));
        $file->setUserPostulation($em->getRepository(Utilisateur::class)->find($request->get('user')));
        $file->setAnnoncePostulation($em->getRepository(Annonce::class)->find($request->get('annonce')));

        $entityManager->persist($file);
        $entityManager->flush();

        $serializer = new Serializer( [new ObjectNormalizer()]);

        $formated = $serializer->normalize("ok");
        return new JsonResponse($formated);
    }







    #[Route('/api/supprimerPostulation/{id}', name: 'app_supprimer_Postulation')]
    public function deletefile($id,EntityManagerInterface $entityManager)
    {

        $em=$this->getDoctrine()->getManager();
        $res = $entityManager->getRepository(Postulation::class)
            ->find($id);
        $em->remove($res);
        $em->flush();
        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize("ok");
        return new JsonResponse($formated);
    }




    #[Route('/api/accepter/{id}', name: 'apiaccepter')]
    public function accepter(MailerInterface $mailer,$id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository(Postulation::class)->find($id);
        $res->setEtat("Accepter");
        $em->persist($res);
        $em->flush();

        $email = (new Email())
            ->from('istabrak.zouabi001@gmail.com')
            ->to('istabrak.zouabi@esprit.tn')
            ->subject('Your password reset request')
            // ->htmlTemplate('postulation/email.html.twig');
            ->text('This is a test email sent using Symfony Mailer.');
        $mailer->send($email);

        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize("ok");
        return new JsonResponse($formated);
    }


    #[Route('/api/refuser/{id}', name: 'apirefuser')]
    public function refuser(MailerInterface $mailer,$id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository(Postulation::class)->find($id);
        $res->setEtat("Refuser");
        $em->persist($res);
        $em->flush();

        $email = (new Email())
            ->from('istabrak.zouabi001@gmail.com')
            ->to('istabrak.zouabi@esprit.tn')
            ->subject('Your password reset request')
            // ->htmlTemplate('postulation/email.html.twig');
            ->text('This is a test email sent using Symfony Mailer.');
        $mailer->send($email);


        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize("ok");
        return new JsonResponse($formated);
    }





}
