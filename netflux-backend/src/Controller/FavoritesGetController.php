<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;

final class FavoritesGetController extends AbstractController
{

    public function __invoke(): JsonResponse
    {      
        /** @var User $user */

        $user = $this->getUser();

        if(!$user) {
            return $this->json(['error' => 'Utilisateur non connecté.'], 401);
        }

        $favorites = $user->getFavoris();
        $data = [];

        foreach ($favorites as $movie) {
            $data[] = [
                'id' => $movie->getId(),
                'title' => $movie->getTitle(),
                'releaseDate' => $movie->getReleaseDate(),
                'rating' => $movie->getRating(),
                'imagePath' => $movie->getImagePath(),
            ];
        }
        return $this->json($data);
    }
}
