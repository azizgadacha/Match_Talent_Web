<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    #[Route('/admin', name: 'admin')]
    public function indexBackOffice(Security $security): Response
    {
      //  echo "ahla bb sava ".$security->getUser()->getNomSociete(). " y3aychik hamdoulah";
        //echo $security->getUser()->getUsername();


        return $this->render('index/admin.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
