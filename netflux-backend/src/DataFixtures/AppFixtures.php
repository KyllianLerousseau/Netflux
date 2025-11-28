<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\User;
use App\Enum\MovieType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        // throw new \Exception('Not implemented');
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // $genres = ['Action', 'Comédie', 'Drame', 'Science-Fiction', 'Horreur', 'Romance', 'Thriller'];
        // $genreObjects = [];

        // foreach ($genres as $name) {
        //     $genre = new Genre();

        //     $genre->setName($name);

        //     $manager->persist($genre);
        //     $genreObjects[] = $genre;
        // }

        // for ($i = 0; $i <= 5; $i++) {
        //     $user = new User();

        //     $user->setEmail($faker->email());
        //     $user->setPseudo($faker->userName());
        //     $user->getRoles();

        //     $hashedPassword = $this->passwordHasher->hashPassword(
        //         $user,
        //         'password'
        //     );
        //     $user->setPassword($hashedPassword);

        //     $manager->persist($user);
        // }

        // $titles = [
        //     'Le Dernier Voyage',
        //     'L’Ombre du Passé',
        //     'Les Étoiles Perdues',
        //     'La Nuit des Secrets',
        //     'Un Autre Monde',
        //     'La Mélodie du Cœur',
        //     'Le Temps des Héros',
        //     'Sous le Même Ciel',
        //     'Au Bord du Rêve',
        //     'Les Larmes de l’Aube',
        //     'La Ville Fantôme',
        //     'Rêves Brisés',
        //     'Les Ombres du Silence',
        //     'L’Énigme du Temps',
        //     'La Dernière Étoile',
        //     'Au-Delà des Montagnes',
        //     'Le Sourire de l’Ombre',
        //     'Entre Deux Mondes',
        //     'Les Chemins de la Liberté',
        //     'La Promesse de l’Automne',
        //     'Éclats de Verre',
        //     'Le Chant des Sirènes',
        //     'La Mémoire des Vents'
        // ];

        // $pitches = [
        //     "Un jeune homme part à l'aventure pour retrouver sa sœur disparue.",
        //     "Dans une ville en ruines, un groupe de survivants lutte pour sa survie.",
        //     "Une histoire d'amour inattendue bouleverse la vie de deux inconnus.",
        //     "Un détective enquête sur une série de meurtres mystérieux.",
        //     "Lorsqu'un scientifique découvre un portail vers une autre dimension, tout change.",
        //     "Une jeune femme découvre un secret de famille qui va tout bouleverser.",
        //     "Pendant l'été, des adolescents découvrent que rien n'est jamais comme il paraît.",
        //     "Dans le Paris du futur, la société est divisée et une rébellion se prépare.",
        //     "Un ancien soldat doit affronter ses démons pour protéger sa ville.",
        //     "Une comédie où des voisins improbables deviennent amis malgré leurs différences."
        // ];

        // shuffle($titles);
        // for ($i = 0; $i < 23; $i++) {
        //     $movie = new Movie();

        //     $movie->setTitle($titles[$i]);
        //     $sentences = $faker->randomElements($pitches, $faker->numberBetween(2, 4));
        //     $movie->setSynopsis(implode(' ', $sentences));
        //     $movie->setReleaseDate($faker->dateTimeBetween('-20 years', 'now'));
        //     $movie->setImageUrl($faker->imageUrl(640, 900, 'movie', true));

        //     $types = MovieType::cases();
        //     $movie->setType($faker->randomElement($types));

        //     if ($movie->getType() === MovieType::MOVIE) {
        //         $movie->setDuration($faker->numberBetween(80, 120));
        //     } else {
        //         $movie->setDuration(null);
        //     }

        //     $movie->setRating($faker->randomFloat(1, 1, 10));

        //     $randomGenres = $faker->randomElements($genreObjects, $faker->numberBetween(1, 3));
        //     foreach ($randomGenres as $genre) {
        //         $movie->addGenre($genre);
        //     }

        //     $manager->persist($movie);
        // }

        // $user = new User();
        // $user->setEmail('admin@netflux.fr');
        // $user->setPseudo("Admin");
        // $user->setRoles(['ROLE_ADMIN']);
        // $user->setPassword($this->passwordHasher->hashPassword($user, 'admin123'));
        // $manager->persist($user);

        // $manager->flush();
    }
}
