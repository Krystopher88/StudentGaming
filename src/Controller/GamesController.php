<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Games;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/jeux', name: 'games_')]
class GamesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('games/index.html.twig', [
            'controller_name' => 'GamesController',
        ]);
    }

    #[Route('/{slug}', name: 'show')]
    public function show(): Response
    {
        return $this->render('games/show.html.twig', [
            'controller_name' => 'GamesController',
        ]);
    }
}
