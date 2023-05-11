<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/images-user", name="images_user")
     */
    public function ImagesUserAction(Request $request)
    {
        $publicResourcesFolderPath = $this->get('kernel')->getRootDir() . '/../web/users_photo/ ';
        $image = $request->query->get("photo");
        // This should return the file located in /mySymfonyProject/web/public-resources/TextFile.txt
        // to being viewed in the Browser
        return new BinaryFileResponse($publicResourcesFolderPath . $image);
    }

    /**
     * @Route("/edituser", name="edit_user")
     */
    public function EditUserAction(Request $request)
    {
        $id = $request->get("id");
        $username = $request->get("name");
        $email = $request->get("email");
        $contact = $request->get("contact");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);


        $user->setName($username);
        $user->setContact($contact);
        $user->setEmail(urldecode($email));

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return new Response("success");
        } catch (Exception $ex) {
            return new Response("fail");
        }
    }

    /**
     * @Route("/get-user-by-id", name="get_user_by_id")
     */
    public function GetUserbyIdAction(Request $request)
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)
            ->find($request->get('id'));

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/get-pass-by-email", name="get_pass_by_email")
     */
    public function GetPassbyEmailAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->findOneBy(['email' => $request->get('email')]);

        if ($user == null) {
            return new Response("fail");
        } else {
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($user->getPassword());
            return new JsonResponse($formatted);
        }
    }

    /**
     * @Route("/login", name="login")
     */

    //***********Login******************************//
    public function loginAction(Request $request)
    {
        $username = $request->query->get("email");
        $password = $request->query->get("password");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['email' => $username]);
        // $user->setPlainPassword($user->getPlainPassword());
        if ($user == null) {

        }
        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($user);
                return new JsonResponse($formatted);
            } else {
                return new Response("failed");
            }
        } else {
            return new Response("failed");
        }

    }

    /**
     * @Route("/register", name="register")
     */
    //*********Register***************************//
    public function registerAction(Request $request)
    {
        $username = $request->query->get("name");
        $password = $request->query->get("password");
        $email = $request->query->get("email");
        $role = $request->query->get("roles");
        $contact = $request->query->get("contact");

        $user = new User();
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setName($username);
        $user->setRoles(array($role));

        $user->setContact($contact);
        try {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return new Response("success");
        } catch (Exception $ex) {
            return new Response("fail");
        }
    }

    /**
     * @Route("/alluser", name="alluser")
     */
    public function AllUsersAction()
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/delete", methods={"GET"})
     */
    public function DeleteUser(Request $request, SerializerInterface $serializer): bool
    {
        $userId = $request->query->get("id");

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($userId);

        if (!$user) {
            return false;
        }

        $normalizer = new ObjectNormalizer();

        $data = $serializer->serialize($user, 'json', ['normalizer' => $normalizer]);

        return true;    }
}