<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request,SessionInterface $session)
    {

        try {
            $user = new User();
            echo "heello1";

            $form = $this->createForm(UserType::class, $user);
            echo "heello2";

            $form->handleRequest($request);
            echo "heello3";

            if ($form->isSubmitted() && $form->isValid()) {
                // Encode the new users password
                echo "heello5";
                $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
                echo "heello4";

                $user->setEmailVerified(true);
                // Save
                $em = $this->getDoctrine()->getManager();
                echo "heello8";

                $em->persist($user);
                echo "heello9";

                $em->flush();

                return $this->redirectToRoute('app_login');
            }

            return $this->render('registration/register.html.twig', [
                'form' => $form->createView(),
            ]);

        } catch (\Exception $e) {

            echo "rrrrrrrrrrrrrrr";
            echo $e->getMessage();
            $this->addFlash('error', "ffff".$e->getMessage());

           return $this->redirectToRoute('register');
        }
    }
}