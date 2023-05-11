<?php

namespace App\Controller;

use App\Entity\Postulation;
use App\Form\PostulationType;
use App\Repository\AnnonceRepository;
use App\Repository\FileRepository;
use App\Repository\PostulationRepository;
use App\Repository\UtilisateurRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Serializer\SerializerInterface;
#[Route('/postulation')]
class PostulationController extends AbstractController
{


    #[Route('/chart', name: 'my_chart')]
    public function myChart(PostulationRepository $postulationRepository, SerializerInterface $serializer): Response
    {
        $postulationStatistics = $postulationRepository->getPostulationStatisticsByAnnonce();

        $chartData = [
            ['Annonce', 'Nombre de postulations'],
        ];

        foreach ($postulationStatistics as $statistic) {
            $chartData[] = [$statistic['annonce'], $statistic['count']];
        }
   // dd($chartData);
        // Create the chart object and set the data
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable($chartData);
        $pieChart->getOptions()->setWidth(500);
        $pieChart->getOptions()->setHeight(400);
        $pieChart->setElementID('my');

       // dd($pieChart);
        return $this->render('postulation/chart.html.twig', [
            'piechart' => $pieChart
        ]);
    }


    #[Route('/annoce', name: 'app_ann_index', methods: ['GET'])]
    public function annaoncef(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('postulation/annoce.html.twig', [
            'annonce' => $annonceRepository->findAll(),
        ]);
    }

    #[Route('/', name: 'app_postulation_index', methods: ['GET'])]
    public function index(PostulationRepository $postulationRepository,UtilisateurRepository $utilisateurRepository): Response
    {
        $user= $utilisateurRepository->find(6);
        return $this->render('postulation/index.html.twig', [
            'postulations' => $postulationRepository->findBy(array('userPostulation'=>$user)),
        ]);
    }


    #[Route('/admin', name: 'app_admin', methods: ['GET'])]
    public function indexAdmin(Request $request,PostulationRepository $postulationRepository, PaginatorInterface $paginator): Response
    {
        $donnees = $postulationRepository->findAll();
        $articles = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            2 // Nombre de résultats par page
        );
        return $this->render('postulation/indexBackOffice.html.twig', [
            'postulations' => $articles,
        ]);
    }

    #[Route('/new/{idAnnonce}', name: 'app_postulation_new', methods: ['GET', 'POST'])]
    public function new(Request $request,$idAnnonce, AnnonceRepository $annonceRepository, FileRepository $fileRepository, PostulationRepository $postulationRepository, UtilisateurRepository $utilisateurRepository): Response
    {
        $utilisateur = $utilisateurRepository->find(6);
        $annonce=$annonceRepository->find($idAnnonce);
        $postulation = new Postulation();

            $file=$fileRepository->findOneBy(array('userFile'=>$utilisateur));
            $postulation->setEtat("en cours");
            $postulation->setFileAssocier($file);
            $postulation->setAnnoncePostulation($annonce);
            $postulation->setUserPostulation($utilisateur);
            $postulation->setDate(new \DateTime);
            $postulationRepository->save($postulation, true);

            return $this->redirectToRoute('app_postulation_index', [], Response::HTTP_SEE_OTHER);


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

    #[Route('/deletepos/{id}', name: 'deletepost')]
    public function delete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository(Postulation::class)->find($id);
        $em->remove($res);
        $em->flush();
        return $this->redirectToRoute('app_postulation_index');
    }

    #[Route('/accepter/{id}', name: 'accepter')]
    public function accepter(MailerInterface $mailer,$id,FlashyNotifier $flashy): Response
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
        $flashy->success('Accepter');

        return $this->redirectToRoute('app_admin');
    }


    #[Route('/refuser/{id}', name: 'refuser')]
    public function refuser(MailerInterface $mailer,$id,FlashyNotifier $flashy): Response
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
        $flashy->error('Refuser');


        return $this->redirectToRoute('app_admin');
    }





}
