<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FavoritesDeleteController extends AbstractController
{

    public function __invoke(int $id, int $movie_id, EntityManagerInterface $em): JsonResponse
    {
        /** @var User $user **/
        $user = $this->getUser();

        if (!$user) {
            return $this->json(['error' => 'Utilisateur non connecté'], 401);
        }

        $movie = $em->getRepository(Movie::class)->find($movie_id);
        if (!$movie) return $this->json(['error' => 'Film non trouvé'], 404);

        if (!$user->getFavoris()->contains($movie)) {
            return $this->json(['error' => 'Film non présent dans les favoris'], 400);
        }

        $user->removeFavori($movie);
        $em->flush();

        return $this->json(['message' => 'Film supprimé des favoris'], 204);
    }
}
