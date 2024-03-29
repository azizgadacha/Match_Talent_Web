<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FileType;
use App\Repository\FileRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/file')]
class FileController extends AbstractController
{
    #[Route('/', name: 'app_file_index', methods: ['GET'])]
    public function index(Security $security,FileRepository $fileRepository,UserRepository $UserRepository): Response
    {
        $user = $security->getUser();

        return $this->render('file/index.html.twig', [
            'files' => $fileRepository->findBy(array('userFile'=>$user)),
        ]);
    }

    #[Route('/new', name: 'app_file_new', methods: ['GET', 'POST'])]
    public function new(Security $security,Request $request, UserRepository $UserRepository,FileRepository $fileRepository): Response
    {
        $file = new File();
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);
        $user = $security->getUser();


        if ($form->isSubmitted() && $form->isValid()) {
            $user = $security->getUser();
            $file->getUploadFileCv();
            $file->getUploadFileDeplome();
            $file->getUploadFileMotivation();
            $file->setUserFile($user);
            $fileRepository->save($file, true);

            return $this->redirectToRoute('app_file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file/new.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    #[Route('/{idFile}', name: 'app_file_show', methods: ['GET'])]
    public function show(File $file): Response
    {
        return $this->render('file/show.html.twig', [
            'file' => $file,
        ]);
    }

    #[Route('/{idFile}/edit', name: 'app_file_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, File $file, FileRepository $fileRepository): Response
    {
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file->getUploadFileCv();
            $file->getUploadFileDeplome();
            $file->getUploadFileMotivation();
            $fileRepository->save($file, true);

            return $this->redirectToRoute('app_file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file/edit.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }


    #[Route('/deleteFile/{id}', name: 'deletefile')]
    public function delete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository(File::class)->find($id);
        $em->remove($res);
        $em->flush();
        return $this->redirectToRoute('app_file_index');
    }
}
