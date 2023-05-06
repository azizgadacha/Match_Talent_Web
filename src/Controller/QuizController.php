<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\Quiz;
use App\Entity\User;
use App\Form\QuizType;
use App\Repository\AnnonceRepository;
use App\Repository\CandidatureRepository;
use App\Repository\PostulationRepository;
use App\Repository\QuizRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuestionRepository;
use Knp\Component\Pager\PaginatorInterface;



use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\ChartOptions;

use CMEN\GoogleChartsBundle\GoogleCharts\Chart;
use CMEN\GoogleChartsBundle\GoogleCharts\EventType;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\ChartOptionsInterface;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\PieChart\PieChartOptions;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use Symfony\Component\Security\Core\Security;


#[Route('/quiz')]
class QuizController extends AbstractController
{
    #[Route('/backend', name: 'app_quiz_index1', methods: ['GET'])]
    public function index2(QuizRepository $quizRepository): Response
    {
        return $this->render('quiz/indexbackend.html.twig', [
            'quizzes' => $quizRepository->findAll(),
        ]);
    }
    
    
    #[Route('/', name: 'app_quiz_index', methods: ['GET'])]
    public function index(Security $security,QuizRepository $quizRepository): Response
    {
        $user = $security->getUser();

        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizRepository->findBy(["userQuiz"=>$user]),
        ]);
    }
    #[Route('/adminQuiz', name: 'admin_app_quiz_index', methods: ['GET'])]
    public function indexadmin(Security $security,QuizRepository $quizRepository): Response
    {
        $user = $security->getUser();

        return $this->render('quiz/indexbackend.html.twig', [
            'quizzes' => $quizRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_quiz_new', methods: ['GET', 'POST'])]
    public function new(Security $security,Request $request, QuizRepository $quizRepository,UserRepository $UserRepository ): Response
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $security->getUser();


            $quiz->setUserQuiz($user);
            $quizRepository->save($quiz, true);
    
            return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('quiz/new.html.twig', [
            'quiz' => $quiz,
            'form' => $form,
        ]);
    }
    

    #[Route('/{idQuiz}', name: 'app_quiz_show', methods: ['GET'])]
    public function show(Quiz $quiz): Response
    {
        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
        ]);
    }

    #[Route('/{idQuiz}/edit', name: 'app_quiz_edit', methods: ['GET', 'POST'])]
    public function edit(Security $security,Request $request, Quiz $quiz, QuizRepository $quizRepository,UserRepository $UserRepository): Response
    {
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $User = $security->getUser();
            $quiz->setUserQuiz($User);
            $quizRepository->save($quiz, true);

            return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quiz/edit.html.twig', [
            'quiz' => $quiz,
            'form' => $form,
        ]);
    }

    #[Route('/{idQuiz}', name: 'app_quiz_delete', methods: ['POST'])]
    public function delete(Request $request, Quiz $quiz, QuizRepository $quizRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quiz->getIdQuiz(), $request->request->get('_token'))) {
            $quizRepository->remove($quiz, true);
        }

        return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/{idQuiz}/{idAnnonce}/play', name: 'app_quiz_play', methods: ['GET', 'POST'])]
    public function playQuiz(AnnonceRepository $annonceRepository,$idAnnonce, PostulationRepository $postulationRepository,Security $security,CandidatureRepository $candidatureRepository,Quiz $quiz, Request $request, QuestionRepository $questionRepository): Response
    {
        // Récupérer les questions associées à un quiz par son ID
        $questions = $questionRepository->findBy(['QuizAssocier' => $quiz->getIdQuiz()]);
        // Initialiser le score
        $score = 0;

         $tempsRestant = 30;
    
        // Vérifier si le formulaire a été soumis
        if ($request->isMethod('POST')) {
            // Parcourir les questions une par une
            foreach ($questions as $question) {
                // Récupérer la réponse de l'utilisateur pour cette question
                $reponseUtilisateur = $request->request->get('reponse' . $question->getIdQuestion());
    
                // Vérifier si la réponse de l'utilisateur est correcte
                if ($reponseUtilisateur === $question->getIdBonneReponse()) {
                    $score++; // Incrémenter le score si la réponse est correcte
                }
            }
    
            // Calculer le pourcentage de bonnes réponses
            $pourcentage = ($score / count($questions)) * 100;

            // Créer un nouvel objet PieChart
            $chart = new PieChart();

            
            // Ajouter les données au graphique à partir d'un tableau en PHP
            $chart->getData()->setArrayToDataTable([
            ['Question', 'Pourcentage'],
            ['Bonnes Réponses', $score],
            ['Mauvaises Réponses', count($questions) - $score]
            ]);

// Définir les options du graphique
$chart->getOptions()->setTitle('Répartition des bonnes et mauvaises réponses');
$chart->getOptions()->getTitleTextStyle()->setColor('#000000'); // Noir
$chart->getOptions()->getTitleTextStyle()->setBold(true);
$chart->getOptions()->getTitleTextStyle()->setItalic(true);
$chart->getOptions()->getTitleTextStyle()->setFontName('Arial');
$chart->getOptions()->getTitleTextStyle()->setFontSize(20);
$chart->getOptions()->getLegend()->getTextStyle()->setColor('#000000'); // Noir
$chart->getOptions()->setHeight(300);
$chart->getOptions()->setWidth(600);
$chart->getOptions()->setBackgroundColor('#FFFFFF'); // Blanc
$chart->getOptions()->setColors([ '#90EE90','#FFA07A']); // Couleurs plus claires pour les bonnes et mauvaises réponses
            $user = $security->getUser();

           $candidature=new Candidature();
            $annonce=$annonceRepository->find($idAnnonce);
           $candidature->setAnnonceAssocier($annonce);
           $candidature->setUtilisateurAssocier($user);
           $candidature->setNote($pourcentage);



            $candidatureRepository->save($candidature,true);
           $postulation= $postulationRepository->findOneBy(["annoncePostulation"=>$annonce,"userPostulation"=>$user]);
           $postulation->setEtat("en attent apres quiz");
           $postulationRepository->save($postulation,true);
            // Renvoyer le score sous forme de pourcentage dans un template Twig
            return $this->render('quiz/score.html.twig', [
                'score' => $pourcentage,
                'totalQuestions' => count($questions),
                'quiz' => $quiz,
                'idAnnonce'=>$idAnnonce,
                'chart' => $chart
            ]);
        }
    
        // Renvoyer les questions et le quiz à la template play.html.twig pour affichage
        return $this->render('quiz/play.html.twig', [
            'quiz' => $quiz,
            'questions' => $questions,
            'idAnnonce'=>$idAnnonce,
            'tempsRestant' => $tempsRestant
        ]);
    }








}
