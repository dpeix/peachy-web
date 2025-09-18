<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Conv;
use App\Entity\ConvUser;
use App\Entity\Message;
use App\Repository\ConvRepository;
use App\Repository\UserRepository;
use App\Form\ConvType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class MessagingController extends AbstractController
{
    #[Route('/messaging', name: 'messaging_index')]
    public function index(ConvRepository $convRep): Response
    {
        $user = $this->getUser();
        $convs = $convRep->findByUser($user);

        return $this->render('messaging/index.html.twig', [
            'convs' => $convs,
        ]);
    }

    #[Route('/messaging/{id}', name: 'messaging_conv', requirements: ['id' => '\d+'])]
    public function conv(string $id, ConvRepository $convRep): Response
    {
        $conv = $convRep->find($id);

        if (!$conv) {
            throw $this->createNotFoundException('Conversation not found');
        }

        $messages = $conv->getMessages();

        // Fetch usernames of all users in the conversation
        $usernames = [];
        foreach ($conv->getConvUsers() as $convUser) {
            $user = $convUser->getUsers();
            if ($user) {
                $usernames[] = $user->getUsername();
            }
        }

        return $this->render('messaging/conv.html.twig', [
            'conv' => $conv,
            'messages' => $messages,
            'usernames' => $usernames,
        ]);
    }

    #[Route('/messaging/{id}/send', name: 'send_message', methods: ['POST'])]
    public function sendMessage(int $id, Request $request, ConvRepository $convRep, EntityManagerInterface $em, Conv $conv): Response
    {
        $conversation = $convRep->find($id);

        $messageText = $request->request->get('text');
        // Création du message
        $message = new Message();
        $message->setConvs($conversation);
        $message->setAuthor($this->getUser()->getUsername());
        $message->setBody($messageText);
        $message->setDatePost(new \DateTime());
        
        $conv->setDateLastMessage(new \DateTimeImmutable());

        // Persister le message
        $em->persist($message);
        $em->flush();

        // Rediriger vers la page de la conversation avec un message de succès
        $this->addFlash('success', 'Message sent successfully');
        return $this->redirectToRoute('messaging_conv', ['id' => $id]);
    }


    #[Route('/messaging/new', name: 'messaging_new')]
    public function new(Request $request, EntityManagerInterface $em, UserRepository $userRepo): Response
    {
        $conv = new Conv();
        $currentUser = $this->getUser();

        $form = $this->createForm(ConvType::class, $conv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedUsers = $form->get('convUsers')->getData();

            $conv->setDateLastMessage(new \DateTimeImmutable());
            $em->persist($conv);
            
            // Ajouter l'utilisateur courant
            $currentUserConv = new ConvUser();
            $currentUserConv->setUsers($currentUser);
            $currentUserConv->setConvs($conv);
            $currentUserConv->setDateLastCheck(new \DateTimeImmutable());
            $em->persist($currentUserConv);
            
            // Ajouter les utilisateurs sélectionnés
            foreach ($selectedUsers as $user) {
                if ($user !== $currentUser) {
                    $convUser = new ConvUser();
                    $convUser->setUsers($user);
                    $convUser->setConvs($conv);
                    $convUser->setDateLastCheck(new \DateTimeImmutable());
                    $em->persist($convUser);
                }
            }
            
            $em->flush();
            return $this->redirectToRoute('messaging_conv', ['id' => $conv->getId()]);
        }

        return $this->render('messaging/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}