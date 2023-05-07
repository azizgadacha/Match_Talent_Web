<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class JsonController extends AbstractController
{
    #[Route('/afficherJsonCategories', name: 'jsonCategories')]
    public function getCategories(): JsonResponse
    {
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();

        $data = [];
        foreach ($categories as $categorie) {
            $data[] = [
                'Id_categorie' => $categorie->getIdCategorie(),
                'NomCategorie' => $categorie->getNomCategorie(),

            ];
        }

        return new JsonResponse($data);
    }


    #[Route('/ajouterJsonCategories', name: 'ajouter_categorie')]
    public function ajouterCategorie(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $categorie = new Categorie();
        $categorie->setNomCategorie($request->request->get('nom_categorie'));

        $entityManager->persist($categorie);
        $entityManager->flush();

        return new JsonResponse(['message' => 'categorie ajouté avec succès']);
    }




}