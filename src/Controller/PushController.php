<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Pusher\Pusher;

class PushController extends AbstractController
{
    /**
     * @Route("/push", name="push")
     */
    public function push()
    {
        // Create an instance of Pusher with your credentials
        $pusher = new Pusher('67d3b2ccacafad87ac7b', 'c52d4e6c076a978f7a5a', '588413', [
            'cluster' => 'ap1',
        ]);
        
        // Trigger a notification to 'my-channel' with 'my-event' event and data
        $pusher->trigger('my-channel', 'my-event', [
            'message' => 'Hello, world!',
        ]);

        // Return a response
        return $this->render('push/push.html.twig', [
            'message' => 'Notification sent!',
        ]);
    }
}
