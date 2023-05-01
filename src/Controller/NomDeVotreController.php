<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Utilisateur;
use App\Repository\ReclamationRepository;
use App\Repository\UtilisateurRepository;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NomDeVotreController extends AbstractController
{
    #[Route('/nom/de/votre', name: 'app_nom_de_votre')]
    public function index(): Response
    {


        return $this->render('nom_de_votre/index.html.twig', [
            'controller_name' => 'NomDeVotreController',
        ]);
    }

    #[Route('/getclasses', name: 'getclasses')]
    public function getclasses(ReclamationRepository $doctrine)
    {

            $listClasse=$doctrine->findAll();


        return $this->render('nom_de_votre/index.html.twig', ['liste'=>$listClasse,
            'controller_name' => 'ClassroomController',
        ]);
    }
}
