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

            $form = $this->createForm(UserType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Encode the new users password
                $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

                $user->setEmailVerified(true);
                // Save
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('app_login');
            }

            return $this->render('registration/register.html.twig', [
                'form' => $form->createView(),
            ]);

        } catch (\Exception $e) {
            $this->addFlash('error', 'The email address already exists.');

            return $this->redirectToRoute('register');
        }
    }
}