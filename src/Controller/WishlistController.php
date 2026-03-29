<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WishlistController extends AbstractController
{
    #[Route('/wishlist', name: 'app_wishlist')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->render('wishlist/index.html.twig', [
            'games' => $user->getWishlistGames(),
        ]);
    }

    #[Route('/wishlist/add/{id}', name: 'app_wishlist_add', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function add(Game $game, EntityManagerInterface $em): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $user->addWishlistGame($game);
        $em->flush();

        return $this->redirectToRoute('app_game_list');
    }

    #[Route('/wishlist/remove/{id}', name: 'app_wishlist_remove', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function remove(Game $game, EntityManagerInterface $em): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $user->removeWishlistGame($game);
        $em->flush();

        return $this->redirectToRoute('app_game_list');
    }
}