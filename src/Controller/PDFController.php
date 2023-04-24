<?php

namespace App\Controller;





use App\Repository\CandidatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Routing\Annotation\Route;


class PDFController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/pdf', name: 'pdf_generater')]

    public function listp(CandidatureRepository $candidatureRepository,EntityManagerInterface $entityManager , Request $request) : Response
{

    // Configure Dompdf according to your needs

    //$pdfOptions->set('defaultFont', 'Arial');

    // Configure Dompdf according to your needs
    $options = new Options();
    $options->set('isRemoteEnabled', true);

    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($options);

    $candidature = $candidatureRepository->findAll();

    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('candidature/pdfCandidature.html.twig', [
        'candidatures' => $candidature
    ]);

    // Load HTML to Dompdf
    $dompdf->loadHtml($html);
    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
    $dompdf->setPaper('A4', 'portrait');
    // Render the HTML as PDF
    $dompdf->render();
    // Output the generated PDF to Browser (force download)
    $dompdf->stream("MyList.pdf", [
        "Attachment" => false
    ]);
    $dompdf->output();

    return new Response('success');

}

}