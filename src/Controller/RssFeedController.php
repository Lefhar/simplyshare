<?php
// src/Controller/RssFeedController.php
namespace App\Controller;

use App\Entity\RssFeed;
use App\Form\RssFeedType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RssFeedController extends AbstractController
{
    #[Route('/rss/new', name: 'rss_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        // L'utilisateur doit être connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $rssFeed = new RssFeed();
        $form = $this->createForm(RssFeedType::class, $rssFeed);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rssFeed->setUser($this->getUser());
            $em->persist($rssFeed);
            $em->flush();

            $this->addFlash('success', 'Flux RSS ajouté avec succès.');
            return $this->redirectToRoute('rss_list');
        }

        return $this->render('rss_feed/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/rss', name: 'rss_list')]
    public function list(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $rssFeeds = $user->getRssFeeds();

        return $this->render('rss_feed/list.html.twig', [
            'rssFeeds' => $rssFeeds,
        ]);
    }
}
