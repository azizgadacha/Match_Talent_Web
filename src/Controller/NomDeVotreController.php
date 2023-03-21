<?php

namespace App\Controller;

use App\Entity\Utilisateur;
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
    public function getclasses(UtilisateurRepository $doctrine)
    {
        $listClasse=null;

            $listClasse=$doctrine->findAll();


        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
}
