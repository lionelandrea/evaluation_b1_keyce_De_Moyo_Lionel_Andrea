<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameController extends AbstractController
{
    #[Route('/game/list', name: 'app_game_list')]
    public function list(GameRepository $repo): Response
    {
        return $this->render('game/list.html.twig', [
            'games' => $repo->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/game/{id}', name: 'app_game_show', requirements: ['id' => '\d+'])]
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }
}