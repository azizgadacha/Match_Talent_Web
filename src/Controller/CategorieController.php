<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorie')]
class CategorieController extends AbstractController
{
    #[Route('/', name: 'app_categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/allcategories', name: "list")]
    public function index_json(CategorieRepository $categorieRepository, NormalizerInterface $normalizer): Response
    {

            $categories = $categorieRepository->findAll();
        $data = [];

        foreach ($categories as $categorie) {




            $data[] = [
                'idcategorie' => $categorie->getIdCategorie(),
                'nomCategorie' => $categorie->getNomCategorie(),

            ];}
        return new JsonResponse($data);
    }

    /*#[Route('/mobile', name: 'app_rendez_vous_index_trie', methods: ['GET'])]
    public function indexTrieMobile(Request $request,PaginatorInterface $paginator,RendezVousRepository $rendezVousRepository): Response
    {

        $Rendezvous=$rendezVousRepository->findAll();


        $data = [];

        foreach ($Rendezvous as $rendezvous) {


            $formattedDate =$rendezvous->getDateRendezVous()-> format('d/m/Y');




            $data[] = [
                'idRendezVous' => $rendezvous->getIdRendezVous(),
                'DateRendezVous' => $formattedDate,
                'Heure' => $rendezvous->getHeureRendezVous(),
                'id'=>$rendezvous ->getUserRendezVous()->getId(),
                'name'=>$rendezvous->getUserRendezVous()->getName(),
                'idAnnonce'=>$rendezvous->getAnnonceAssocierRendezVous()->getIdAnnonce(),
                'titre'=>$rendezvous->getAnnonceAssocierRendezVous()->getTitre(),
                'Societe'=>$rendezvous->getAnnonceAssocierRendezVous()->getSociete(),
            ];
        }*/

    #[Route('/find/{nomcategorie}', name: 'app_annonce_find', methods: ['POST'])]
    public function find(Request $request, AnnonceRepository $annonceRepository, CategorieRepository $categorieRepository,$nomcategorie)
    {
        $categories = $categorieRepository->findAll();

        return $this->render('annonce/demandeur_index.html.twig', [
            'annonces' => $annonceRepository->findAnnonceByCategorie($nomcategorie),
            'categories' => $categories,
        ]);
    }
    #[Route('/new', name: 'app_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategorieRepository $categorieRepository): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorieRepository->save($categorie, true);

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/new-json', name: 'app_categorie_new_json')]
    public function new_json(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = new Categorie;
        $categorie->setNomCategorie($request->get('nomCategorie'));
        $em->persist($categorie);
        $em->flush();

        $json = $normalizer->normalize($categorie, 'json', ['groups' => 'categorie']);
        return new Response(json_encode($json));

    }


    #[Route('/{idCategorie}', name: 'app_categorie_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }
    #[Route('/CategorieJSON/{id}', name: 'show', methods: ['GET'])]
    public function show_json($id, CategorieRepository $categorieRepository, NormalizerInterface $normalizer)
    {
        $categorie= $categorieRepository->find($id);
        $categorieNormalieses =  $normalizer->normalize($categorie,'json');
        $json=json_encode($categorieNormalieses);
        return New Response($json);

    }


    #[Route('/{idCategorie}/edit', name: 'app_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorie $categorie, CategorieRepository $categorieRepository): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieRepository->save($categorie, true);

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/UpdateCategorieJSON/{id}', name: 'UpdateUserJSON')]
    public function UpdateCategorieJSON($id,Request $request,NormalizerInterface $normalizer)
    {
        $em= $this->getDoctrine()->getManager();
        $categorie=$em->getRepository(Categorie::class)->find($id);
        $categorie->setNomCategorie($request->get('nomCategorie'));
       // $user->setEtat("activé");
        $em->flush();
        $jsonContent = $normalizer->normalize($categorie, 'json');
        return new Response("Mise a jour avec succées   ".json_encode($jsonContent));

    }

    #[Route('/{idCategorie}', name: 'app_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, CategorieRepository $categorieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getIdCategorie(), $request->request->get('_token'))) {
            $categorieRepository->remove($categorie, true);
        }

        return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete_json/{idCategorie}', name: 'app_categorie_delete_json')]
    public function delete_json(Request $request, $idCategorie, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie =  $em ->getRepository(Categorie::class)->find($idCategorie);
        $em->remove($categorie);
        $em->flush();

        return new Response("categorie deleted successfully.");}


}
