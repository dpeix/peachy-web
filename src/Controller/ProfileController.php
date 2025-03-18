<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(PostRepository $postRepository): Response
    {
        // Vérification si l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer les informations de l'utilisateur (ex. depuis la base de données)
        $user = $this->getUser();

        // Récupérer les tweets récents de l'utilisateur
        $posts = $postRepository->findBy(['user' => $user], ['createdAt' => 'DESC']);

        return $this->render('profile/profile.html.twig', [
            'user' => $user,
            'posts' => $posts,
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/profile/{username}', name: 'app_user_profile')]
    public function userProfile(string $username, UserRepository $userRepository, PostRepository $postRepository): Response
    {
        // Récupérer l'utilisateur par son nom d'utilisateur
        $user = $userRepository->findOneBy(['username' => $username]);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        // Récupérer les tweets récents de l'utilisateur
        $posts = $postRepository->findBy(['user' => $user], ['createdAt' => 'DESC']);

        return $this->render('profile/profile.html.twig', [
            'user' => $user,
            'posts' => $posts,
            'controller_name' => 'ProfileController',
        ]);
    }
}