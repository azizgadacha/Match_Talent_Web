<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    } #[Route('/', name: 'app_index_page')]
    public function indexpage(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    #[Route('/admin', name: 'app_index1')]
    public function indexBackOffice(): Response
    {
        return $this->render('index/admin.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
