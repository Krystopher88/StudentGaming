<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ConsoleRepository;
use App\Repository\GamesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ConsoleRepository $consoleRepository,
    CategoryRepository $categoryRepository,
    GamesRepository $gamesRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'consoles' => $consoleRepository->findBy([], ['name' => 'ASC']),
            'categorys' => $categoryRepository->findBy([], ['name' => 'ASC']),
            'games' => $gamesRepository->findAll(),
        ]);
    }
}
