<?php

namespace App\Controller;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateurRepository;
use App\Repository\RoleRepository;
use \Symfony\Component\Notifier\ChatterTrait;
use Twig\Environment;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
#[Route('/annonce')]
class AnnonceController extends AbstractController
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    #[Route('/', name: 'app_annonce_index', methods: ['GET'])]
    public function index(AnnonceRepository $annonceRepository, CategorieRepository  $categorieRepository, UtilisateurRepository $utilisateurRepository, RoleRepository $roleRepository): Response
    {
        $utilisateur = $utilisateurRepository->find(3);
        $role = $utilisateur->getRoleUser();
        $isDemander = $role->getNomRole() === 'DEMANDEUR';


        if ($isDemander) {
          //  $annonces = $annonceRepository->findAllByUtilisateur($utilisateur);
            $categories = $categorieRepository->findAll();

            $annonces = $annonceRepository->findAll();

            return $this->render('annonce/demandeur_index.html.twig', [
               'categories' => $categories,
                'annonces' => $annonces,
                'isDemander' => true
            ]);
        } else {
            $annonces = $annonceRepository->findAll();


            return $this->render('annonce/index.html.twig', [
                'annonces' => $annonces,
                'isDemander' => false
            ]);
        }

    }



    #[Route('/ByTitre', name: 'app_listt', methods: ['GET', 'POST'])]
    public function ByTitree(Request $request, AnnonceRepository $annonceRepository)
    {
        // Default order is ASC if not provided
        $order = $request->query->get('order', 'ASC');

        // Query the annonce data from the database and sort it based on the order
        $annonces = $this->getDoctrine()->getRepository(Annonce::class)->findByTitreAlphabetically($order);

        // Render the sorted annonce data to a Twig template
        $html = $this->twig->render('annonce/tri.html.twig', ['annonces' => $annonces]);

        return new Response($html);
    }


    #[Route('/new', name: 'app_annonce_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnnonceRepository $annonceRepository, UtilisateurRepository $utilisateurRepository, ManagerRegistry $doctrine): Response
    {
        $utilisateur = $utilisateurRepository->find(3);
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em =$doctrine->getManager();
            $annonce->setUtilisateur($utilisateur);

            $annonceRepository->save($annonce, true);

            return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
            
        ]);
          
    }

    #[Route('/{idAnnonce}', name: 'app_annonce_show', methods: ['GET'])]
    public function show(Annonce $annonce): Response
    {
      
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Route('/{idAnnonce}/edit', name: 'app_annonce_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonceRepository->save($annonce, true);

            return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/{idAnnonce}', name: 'app_annonce_delete', methods: ['POST'])]
    public function delete(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getIdAnnonce(), $request->request->get('_token'))) {
            $annonceRepository->remove($annonce, true);
        }

        return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/annonces/categorie/{nomcategorie}', name: 'annonces_by_category')]
    public function annoncesByCategorie(AnnonceRepository $repository, $nomcategorie): Response
    {
        $annonces = $repository->findAnnonceByCategorie($nomcategorie);

        return $this->render('annonce/demandeur_index.html.twig', [
            'annonces' => $annonces,
        ]);
    }




    #[Route('/{idAnnonce}/favorite', name: 'app_annonce_favorite', methods: ['POST'])]
    public function addToFavorites(Request $request, Annonce $annonces, EntityManagerInterface $entityManager, UtilisateurRepository $utilisateurRepository): Response
    {
        $utilisateur = $utilisateurRepository->find(5);

        // Add the current user to the annonce's list of favorite users
        $annonces->addFavoriteUtilisateur($utilisateur);
        $entityManager->flush();

        $this->addFlash('success', 'Announcement added to favorites.');
        return $this->redirectToRoute('app_annonce_index');
    }


    #[Route('/{idAnnonce}/favorite', name: 'app_annonce_favorite', methods: ['GET', 'POST'])]
    public function mesFavoris(AnnonceRepository $annonceRepository, Utilisateur $utilisateur): Response
    {
        $favoris = $annonceRepository->findFavoritesByUtilisateur($utilisateur);

        return $this->render('annonce/mes_favoris.html.twig', [
            'favoris' => $favoris,
        ]);
    }




  /*  #[Route("/annonces/{id}/publish", name:'annonces_publish', methods: ['GET', 'POST'])]

    public function publish(Annonce $annonce, NotifierInterface $notifier): Response
    {
        $this->send('Annonce published');

        $annonce->setStatus('published');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        // Send a notification to a Slack channel
        $notification = new Notification('Annonce published', ['chat']);
        $recipient = new SlackRecipient('#general');
        $notifier->send($notification, $recipient);

        return $this->redirectToRoute('annonces_show', ['id' => $annonce->getId()]);
    }

    protected function getChatter(): ChatterInterface
    {
        // Use a Slack notifier channel to send messages
        $recipient = new SlackRecipient('#general');
        $texter = new SlackTexter('SLACK_WEBHOOK_URL', $recipient);

        return $texter->asChatter();
    }
*/
   /* public function yourActionMethod()
    {
        // Instantiate the Geocoder service
        $geocoder = new GoogleMaps();

        // Geocode an address
        $result = $geocoder->geocodeQuery(GeocodeQuery::create($societe));

        // Get the latitude and longitude
        $latitude = $result->first()->getCoordinates()->getLatitude();
        $longitude = $result->first()->getCoordinates()->getLongitude();

        // Do something with the latitude and longitude
    }*/
}
