<?php

namespace App\Controller;
use MercurySeries\FlashyBundle\FlashyNotifier;
use App\Entity\Postulation;
use App\Form\PostulationType;
use App\Repository\AnnonceRepository;
use App\Repository\FileRepository;
use App\Repository\PostulationRepository;
use App\Repository\UserRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Knp\Component\Pager\PaginatorInterface;
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
use Symfony\Component\Security\Core\Security;

#[Route('/postulation')]
class PostulationController extends AbstractController
{


    #[Route('/chart', name: 'my_chart')]
    public function myChart(PostulationRepository $postulationRepository): Response
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
    public function index(Security $security,PostulationRepository $postulationRepository,UserRepository $UserRepository): Response
    {
        $user = $security->getUser();
        return $this->render('postulation/index.html.twig', [
            'postulations' => $postulationRepository->findBy(array('userPostulation'=>$user)),

        ]);
    }

    #[Route('/postAnnonce/{idAnnonce}', name: 'app_postulation_annonce', methods: ['GET'])]
    public function indexPostann(AnnonceRepository $annonceRepository,$idAnnonce,PostulationRepository $postulationRepository,UserRepository $UserRepository): Response
    {
        $annonce=$annonceRepository->find($idAnnonce);

        return $this->render('postulation/indexDecider.html.twig', ['idAnnonce'=>$idAnnonce,
            'postulations' => $postulationRepository->findBy(["annoncePostulation"=>$annonce]),
        ]);
    }



    #[Route('/admin', name: 'app_admin_Post', methods: ['GET'])]
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
    public function new(Security $security,FlashyNotifier $flashy,Request $request,$idAnnonce, AnnonceRepository $annonceRepository, FileRepository $fileRepository, PostulationRepository $postulationRepository, UserRepository $UserRepository): Response
    {
        $user = $security->getUser();
        $annonce=$annonceRepository->find($idAnnonce);
        $postulation = new Postulation();
            $file=$fileRepository->findOneBy(array('userFile'=>$user));
            if(empty($file)){
                $this->addFlash('warning', 'une erreur est survenue' );

                $flashy->error("Postulation n'est pas creer vous dever ajouter un cv",'');
                return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);

            }else {

                $postulation->setEtat("en cours");
                $postulation->setFileAssocier($file);
                $postulation->setAnnoncePostulation($annonce);
                $postulation->setUserPostulation($user);
                $postulation->setDate(new \DateTime);
                $postulationRepository->save($postulation, true);
                $flashy->success('categorie created '.$user->getId()." frrrr", '');

                return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
            }

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
    public function delete(PostulationRepository $postulationRepository, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $res = $postulationRepository->find($id);
        $em->remove($res);
        $em->flush();
        return $this->redirectToRoute('app_postulation_annonce', ["idAnnonce"=>$res->getAnnoncePostulation()->getIdAnnonce()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/accepter/{id}', name: 'accepter')]
    public function accepter(PostulationRepository $postulationRepository,MailerInterface $mailer,$id,FlashyNotifier $flashy): Response
    {
        $em = $this->getDoctrine()->getManager();
        $res = $postulationRepository->find($id);
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

        return $this->redirectToRoute('app_postulation_annonce', ["idAnnonce"=>$res->getAnnoncePostulation()->getIdAnnonce()], Response::HTTP_SEE_OTHER);
    }


    #[Route('/refuser/{id}', name: 'app_refuser_Postulation')]
    public function refuser(PostulationRepository $postulationRepository,AnnonceRepository $annonceRepository, MailerInterface $mailer,$id,FlashyNotifier $flashy): Response
    {
        $em = $this->getDoctrine()->getManager();
        $res = $postulationRepository->find($id);
        $idAnnonce=  $res->getAnnoncePostulation()->getIdAnnonce();
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

        $annonce=$annonceRepository->find($idAnnonce);

        return $this->redirectToRoute('app_postulation_annonce', ["idAnnonce"=>$idAnnonce], Response::HTTP_SEE_OTHER);

        //   return $this->redirectToRoute('app_admin');
    }
    #[Route('/PasserQuiz/{id}', name: 'app_Tranferer_Quiz_Postulation')]
    public function PasserQuiz(PostulationRepository $postulationRepository,AnnonceRepository $annonceRepository, MailerInterface $mailer,$id,FlashyNotifier $flashy): Response
    {
        $res = $postulationRepository->find($id);
        $idAnnonce=  $res->getAnnoncePostulation()->getIdAnnonce();
        $res->setEtat("Passer quiz");
        $postulationRepository->save($res,true);

        $email = (new Email())
            ->from('istabrak.zouabi001@gmail.com')
            ->to('istabrak.zouabi@esprit.tn')
            ->subject('Your password reset request')
           // ->htmlTemplate('postulation/email.html.twig');
           ->text('This is a test email sent using Symfony Mailer.');
        $mailer->send($email);
        $flashy->error('Refuser');

        $annonce=$annonceRepository->find($idAnnonce);
        return $this->redirectToRoute('app_postulation_annonce', ["idAnnonce"=>$idAnnonce], Response::HTTP_SEE_OTHER);

        //return $this->render('postulation/indexDecider.html.twig', ["idAnnonce"=>$annonce->getIdAnnonce(),
           // 'postulations' => $postulationRepository->findBy(["annoncePostulation"=>$annonce]),
       // ]);
     //   return $this->redirectToRoute('app_admin');
    }





}
