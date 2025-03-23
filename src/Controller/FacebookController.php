<?php

namespace App\Controller;

use App\Entity\FacebookAccount;
use Doctrine\ORM\EntityManagerInterface;
use Facebook\Facebook;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FacebookController extends AbstractController
{
    #[Route('/connect/facebook', name: 'connect_facebook_start')]
    public function connectFacebook(ClientRegistry $clientRegistry): RedirectResponse
    {
        // Demande les permissions nécessaires
        return $clientRegistry->getClient('facebook')->redirect(
            ['pages_manage_posts', 'pages_read_engagement', 'public_profile'],
            []
        );
    }

    #[Route('/connect/facebook/check', name: 'connect_facebook_check')]
    public function connectFacebookCheck(
        Request $request,
        ClientRegistry $clientRegistry,
        EntityManagerInterface $em
    ): Response {
        // Récupération du token utilisateur via le client OAuth2
        $client = $clientRegistry->getClient('facebook');
        $accessTokenObject = $client->getAccessToken();
        $accessToken = $accessTokenObject->getToken();

        // Initialisation du SDK Facebook pour effectuer des appels à l'API Graph
        $fb = new Facebook([
            'app_id' => $_ENV['FACEBOOK_APP_ID'],
            'app_secret' => $_ENV['FACEBOOK_APP_SECRET'],
            'default_graph_version' => 'v12.0',
        ]);

        try {
            // Récupère la liste des pages administrées par l'utilisateur
            $response = $fb->get('/me/accounts', $accessToken);
            $pages = $response->getDecodedBody();

            // Récupère l'ID de l'utilisateur Facebook
            $userResponse = $fb->get('/me?fields=id', $accessToken);
            $userData = $userResponse->getDecodedBody();
            $facebookId = $userData['id'] ?? 'unknown';
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()]);
        }

        // Recherche un compte Facebook existant ou en crée un nouveau
        $repo = $em->getRepository(FacebookAccount::class);
        $fbAccount = $repo->findOneBy(['facebookId' => $facebookId]);

        if (!$fbAccount) {
            $fbAccount = new FacebookAccount();
            $fbAccount->setFacebookId($facebookId);
        }

        $fbAccount->setAccessToken($accessToken);
        $fbAccount->setPages($pages);
        $fbAccount->setUpdatedAt(new \DateTime());

        $em->persist($fbAccount);
        $em->flush();

        // Affiche un message de succès (sans exposer le token)
        return $this->render('facebook/success.html.twig', [
            'facebookId' => $facebookId,
            'pages'      => $pages,
        ]);
    }
}
