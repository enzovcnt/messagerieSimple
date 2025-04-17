<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
