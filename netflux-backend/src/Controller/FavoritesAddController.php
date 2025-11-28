<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FavoritesAddController extends AbstractController
{

    public function __invoke(Request $request, EntityManagerInterface $em): JsonResponse
    {      
        /** @var \App\Entity\User $user **/
        $user = $this->getUser();

        if (!$user) {
            return $this->json(['error' => 'Utilisateur non connecté'], 401);
        }
        $data = json_decode($request->getContent(), true);
        $movieId = $data['movie_id'] ?? null;

        if (!$movieId) return $this->json(['error' => 'movie_id est requis'], 400);

        $movie = $em->getRepository(Movie::class)->find($movieId);
        if (!$movie) return $this->json(['error' => 'Le film est introuvable'], 404);

        $user->addFavori($movie);
        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'Film ajouté aux favoris']);
    }
}
