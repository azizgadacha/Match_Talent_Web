<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;

use App\Repository\QuestionRepository;

use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Snappy\Pdf;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\DompdfBundle\DompdfBundle;
use Dompdf\Dompdf;
use Dompdf\Options;



#[Route('/question')]
class QuestionController extends AbstractController
{


    #[Route('/backquestion', name: 'app_question_index2', methods: ['GET'])]
    public function index1(QuestionRepository $questionRepository): Response
    {
        return $this->render('question/indexback.html.twig', [
            'questions' => $questionRepository->findAll(),
        ]);
    }

    #[Route('/', name: 'app_question_index', methods: ['GET'])]
    public function index(QuestionRepository $questionRepository,PaginatorInterface $paginator,Request $request): Response
    {
        $questions= [];
        $questions=$questionRepository->findAll();

        // Paginer les résultats
        $pagination = $paginator->paginate($questions,$request->query->getInt('page', 1),3 );
        return $this->render('question/index.html.twig', [
            'questions' => $pagination,
        ]);


    }


    #[Route('/new', name: 'app_question_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuestionRepository $questionRepository): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionRepository->save($question, true);

            return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('question/new.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{idQuestion}', name: 'app_question_show', methods: ['GET'])]
    public function show(Question $question): Response
    {
        return $this->render('question/show.html.twig', [
            'question' => $question,
        ]);
    }

    #[Route('/{idQuestion}/edit', name: 'app_question_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Question $question, QuestionRepository $questionRepository): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionRepository->save($question, true);

            return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('question/edit.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{idQuestion}', name: 'app_question_delete', methods: ['POST'])]
    public function delete(Request $request, Question $question, QuestionRepository $questionRepository): Response
    {
       // if ($this->isCsrfTokenValid('delete'.$question->getIdQuestion(), $request->request->get('_token'))) {
            $questionRepository->remove($question, true);
        //}

        return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/getQuestionsByIdQuiz/{idQuiz}', name: 'app_question_get_questions_by_id_quiz', methods: ['GET'])]
    public function getQuestionsByIdQuiz(int $idQuiz, QuestionRepository $questionRepository, QuizRepository $quizRepository): Response
    {
        // Récupérer le quiz par son ID
        $quiz = $quizRepository->find($idQuiz);
    
        // Récupérer les questions associées à un quiz par son ID
        $questions = $questionRepository->findBy(['QuizAssocier' => $quiz]);
    
        // Renvoyer les questions dans un template Twig
        return $this->render('question/questions_by_id_quiz.html.twig', [
            'questions' => $questions, "idQuiz" => $idQuiz, 'quiz' => $quiz
        ]);
    }

    #[Route('/getQuestionsByIdQuiz/{idQuiz}/pdf', name: 'app_question_print_quiz_pdf', methods: ['GET'])]
    public function printQuizPdf(int $idQuiz, QuestionRepository $questionRepository, QuizRepository $quizRepository): Response
    {
        // Récupérer le quiz par son ID
        $quiz = $quizRepository->find($idQuiz);
    
        // Récupérer les questions associées à un quiz par son ID
        $questions = $questionRepository->findBy(['QuizAssocier' => $quiz]);
    
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();
    
        // Option pour activer l'autoloading des fonts (facultatif)
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
    
        // Récupérer le contenu HTML de la liste des questions avec Twig
        $html = $this->renderView('question/base_pdf.html.twig', [
            'questions' => $questions, "idQuiz" => $idQuiz, 'quiz' => $quiz
        ]);
    
        // Charger le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);
    
        // Générer le PDF
        $dompdf->render();
    
        // Récupérer le contenu du PDF
        $output = $dompdf->output();
    
        // Créer une réponse HTTP avec le contenu du PDF
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/pdf');
    
        // Renvoyer la réponse HTTP
        return $response;
    }
    
    
    





}
