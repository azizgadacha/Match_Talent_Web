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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;







class QuestionMobileController extends AbstractController
{
        #[Route('/backquestion_JSON', name: 'app_questions_json')]
    public function getquestionsJson(QuestionRepository $questionRepository, NormalizerInterface $Normalizer):Response
    {
         $question=$questionRepository->findAll();
         $jsonContent = $Normalizer->normalize($question,'json', ['groups'=> "questions"]);
         
         return new Response(json_encode($jsonContent));
    }


    #[Route('/newjson', name: 'app_question_newjson', methods: ['GET', 'POST'])]
    public function new(Request $request, QuestionRepository $questionRepository,NormalizerInterface $Normalizer,QuizRepository $quizRepository ): Response
    { $question1 = $request->get('question');
    $propositiona = $request->get('propositiona');
    $propositionb = $request->get('propositionb');
    $propositionc = $request->get('propositionc');
    $idBonnereponse = $request->get('idBonnereponse');
    $question = new Question();
    $question->setQuestion($question1);
     
$question->setPropositiona($propositiona);
$question->setPropositionb($propositionb);
$question->setPropositionc($propositionc);
$question->setIdBonnereponse($idBonnereponse);
$Quiz = $quizRepository->find(7);

$question->setQuizAssocier($Quiz);


 $em = $this->getDoctrine()->getManager();
                $em->persist($question);
                $em->flush();
 $jsonContent = $Normalizer->normalize($question, 'json',['groups'=>"questions"]);
    return new Response("La questiona bien été ajoutee". json_encode($jsonContent) );
    }

    #[Route('/updateQjson/{id}', name: 'app_question_editjson', methods: ['GET', 'POST'])]
    public function edit($id,Request $request, Question $question, QuestionRepository $questionRepository,NormalizerInterface $Normalizer): Response
    {    
$question = $questionRepository->find($id);
$testquestion = $request->get('testquestion');
$propositiona = $request->get('propositiona');
$propositionb = $request->get('propositionb');
$propositionc = $request->get('propositionc');
$idBonnereponse = $request->get('idBonnereponse');


$question->setQuestion($testquestion);
$question->setPropositiona($propositiona);
$question->setPropositionb($propositionb);
$question->setPropositionc($propositionc);
$question->setIdBonnereponse($idBonnereponse);
$question->setQuizAssocier(null);

 // Action de Mise à jour

        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $jsonContent = $Normalizer->normalize($question, 'json',['groups'=>"questions"]);
        return new Response("La questiona bien été modifiee". json_encode($jsonContent) );
    
    }
    #[Route('/deleteQjson/{id}', name: 'app_question_deletejson', methods: ['GET'])]
    public function delete($id,Request $request, Question $question, QuestionRepository $questionRepository,NormalizerInterface $Normalizer): Response
    {
        $question = $questionRepository->find($id);
          // supprimer la 
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->remove($question);
          $entityManager->flush();
    $jsonContent = $Normalizer->normalize($question, 'json',['groups'=>"questions"]);

    // retourner une réponse indiquant que la suppression a réussi
    return new Response("La questiona bien été supprimée". json_encode($jsonContent) );
}
    }




   
