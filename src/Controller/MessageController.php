<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MessageController extends AbstractController
{
    #[Route('/', name: 'messages')]
    public function index(MessageRepository $repository): Response
    {

        return $this->render('message/index.html.twig', [
            'messages' => $repository->findAll(),
        ]);
    }

    #[Route('/create', name: 'create_message')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $message = new Message();

        $formMessage = $this->createForm(MessageType::class, $message);

        $formMessage->handleRequest($request);
        if ($formMessage->isSubmitted() && $formMessage->isValid())
        {
            $message->setCreatedAt(new \DateTime());
            $manager->persist($message);
            $manager->flush();
            return $this->redirectToRoute('messages');
        }


        return $this->render('message/create.html.twig', [
            'formMessage' => $formMessage->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_message')]
    public function edit(Message $message, Request $request, EntityManagerInterface $manager): Response
    {

        if(!$message)
        {
            return $this->redirectToRoute('messages');
        }

        $formMessage = $this->createForm(MessageType::class, $message);
        $formMessage->handleRequest($request);
        if ($formMessage->isSubmitted() && $formMessage->isValid()){
            $manager->persist($message);
            $manager->flush();
            return $this->redirectToRoute('messages');
        }
        return $this->render('message/edit.html.twig', [
            'formMessage' => $formMessage->createView(),
        ]);
    }
}
