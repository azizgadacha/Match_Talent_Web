<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/security', name: 'app_security')]
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
    #[Route('/login', name:'app_login', methods: ['GET','POST'])]

        public function login(Request $request, AuthenticationUtils $authenticationUtils, Security $security): Response
    {
        if ($security->getUtilisateur()) {
            return $this->redirectToRoute('app_utilisateur_index');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $Username = $authenticationUtils->getUsername();

        return $this->render('security/login.html.twig', [
            'username' => $Username,
            'error' => $error,

        ]);
    }

    #[Route('/login_check', name:'app_login_check', methods: ['POST'])]
    public function loginCheck()
    {

    }




}
