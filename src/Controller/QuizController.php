<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\Utilisateur;
use App\Form\QuizType;
use App\Repository\QuizRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuestionRepository;


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
    public function index(QuizRepository $quizRepository): Response
    {
        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_quiz_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuizRepository $quizRepository,UtilisateurRepository $utilisateurRepository ): Response
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $User =$utilisateurRepository -> find(5);
           
            $quiz->setUserQuiz($User);
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
    public function edit(Request $request, Quiz $quiz, QuizRepository $quizRepository,UtilisateurRepository $utilisateurRepository): Response
    {
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $User =$utilisateurRepository -> find(5);
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

    #[Route('/{idQuiz}/play', name: 'app_quiz_play', methods: ['GET', 'POST'])]
    public function playQuiz(Quiz $quiz, Request $request, QuestionRepository $questionRepository): Response
    {
        // Récupérer les questions associées à un quiz par son ID
        $questions = $questionRepository->findBy(['QuizAssocier' => $quiz->getIdQuiz()]);
    
        // Initialiser le score
        $score = 0;
    
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
    
            // Renvoyer le score sous forme de pourcentage dans un template Twig
            return $this->render('quiz/score.html.twig', [
                'score' => $pourcentage,
                'totalQuestions' => count($questions),
                'quiz' => $quiz
            ]);
        }
    
        // Renvoyer les questions et le quiz à la template play.html.twig pour affichage
        return $this->render('quiz/play.html.twig', [
            'quiz' => $quiz,
            'questions' => $questions
        ]);
    }
    








}
