<?php

namespace App\Controller;

use APP\Entity\Users;
use App\Entity\Post;
use App\Form\PostFormType; 
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository, Request $request, EntityManagerInterface $em): Response
    {
        // Créer une instance de Tweet
        $post = new Post();

        // Créer un formulaire
        $form = $this->createForm(PostFormType::class, $post, [
            'is_logged_in' => $this->getUser() !== null,
        ]);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
            $user = $this->getUser();
            if (!$user) {
                return $this->redirectToRoute('app_login');
            }

            $post->setCreatedAt(new \DateTimeImmutable()); // Définir la date de création automatiquement
            $post->setUser($user);

            // Définir les valeurs du tweet par défaut
            $post->setState(true);
            // Sauvegarder le tweet dans la base de données
            $em->persist($post);
            $em->flush();

            // Rediriger vers la page d'accueil après soumission
            return $this->redirectToRoute('app_home');
        }

        // Récupérer tous les tweets de la base
        $posts = $postRepository->findAllOrderedByDate();

        // Rendre la vue avec les tweets et le formulaire
        return $this->render('home/index.html.twig', [
            'tweets' => $posts,
            'form' => $form->createView(),
        ]);
    }
}
