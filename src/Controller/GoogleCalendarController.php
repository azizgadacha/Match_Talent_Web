<?php

namespace App\Controller;

use Google_Client;
use Google_Service_Calendar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GoogleCalendarController extends AbstractController
{

    #[Route('/google-calendar', name: 'google_calendar')]

    public function index(Request $request)
    {
        // Create a new Google client instance
        $client = new Google_Client();
        $client->setApplicationName('My Google Calendar App');
        $client->setScopes([Google_Service_Calendar::CALENDAR]);
        $client->setAuthConfig(__DIR__ . '/../../config/client_secret_836230715234-lf5um1v3nl4anj762utg33c225tpbsge.apps.googleusercontent.com.json');
        $client->setAccessType('offline');

        // Handle the OAuth 2.0 authorization flow
        if ($request->query->get('code')) {
            $client->fetchAccessTokenWithAuthCode($request->query->get('code'));
            $accessToken = $client->getAccessToken();
            $refreshToken = $client->getRefreshToken();
            // Save the access and refresh tokens to the database for later use
            // ...
        } else {
            $authUrl = $client->createAuthUrl(['redirect_uri' => 'http://localhost:8000/oauth2callback']);
            return $this->redirect($authUrl);
        }

        // Use the access token to make Google Calendar API requests
        $service = new Google_Service_Calendar($client);
        $calendarId = 'primary';
        $events = $service->events->listEvents($calendarId);

        return $this->render('google_calendar/index.html.twig', [
            'events' => $events,
        ]);
    }
}
