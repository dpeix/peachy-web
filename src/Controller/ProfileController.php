<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(PostRepository $tweetRepository): Response
    {
        // Vérification si l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer les informations de l'utilisateur (ex. depuis la base de données)
        $user = $this->getUser();

        // Récupérer les tweets récents de l'utilisateur
        $tweets = $tweetRepository->findBy(['user' => $user], ['createdAt' => 'DESC']);

        return $this->render('profile/profile.html.twig', [
            'user' => $user,
            'posts' => $tweets,
            'controller_name' => 'ProfileController',
        ]);
    }
}