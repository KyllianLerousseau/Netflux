<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Enum\MovieType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genreNames = [
            'Action',
            'Science-Fiction',
            'Thriller',
            'Drame',
            'Crime',
            'Fantastique',
            'Aventure',
            'Comédie',
            'Policier',
            'Mystère'
        ];
        $genres = [];
        foreach ($genreNames as $name) {
            $g = new Genre();
            $g->setName($name);
            $manager->persist($g);
            $genres[$name] = $g;
        }

        $items = [
            [
                'title' => 'Se7en',
                'synopsis' => 'Deux détectives traquent un tueur en série qui commet ses meurtres selon les sept péchés capitaux.',
                'releaseDate' => '1995-09-22',
                'duration' => 127, // minutes
                'rating' => 8.6,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/69S4xZ61BUhVZv4z8U0gw2gCY7B.jpg', // placeholder
                'videoUrl' => 'https://www.youtube.com/watch?v=ZM2K7h2ZT8o', // placeholder
                'genres' => ['Thriller', 'Crime', 'Mystère']
            ],
            [
                'title' => 'The Matrix',
                'synopsis' => 'Un hacker découvre que la réalité qu’il connaît est une simulation et rejoint une rébellion pour la combattre.',
                'releaseDate' => '1999-03-31',
                'duration' => 136,
                'rating' => 8.7,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=8xx91zoASLY', // trailer VF
                'genres' => ['Action', 'Science-Fiction']
            ],
            [
                'title' => 'Fight Club',
                'synopsis' => 'Un employé de bureau fatigué et un vendeur de savon excentrique créent un club de combat clandestin qui prend une tournure inquiétante.',
                'releaseDate' => '1999-10-15',
                'duration' => 139,
                'rating' => 8.8,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/bptfVGEQuv6vDTIMVCHjJ9Dz8PX.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=SUXWAEX2jlg', // placeholder
                'genres' => ['Drame', 'Mystère']
            ],
            [
                'title' => 'Gladiator',
                'synopsis' => 'Un général romain déchu devient gladiateur et cherche à se venger de l’empereur qui a trahi sa famille.',
                'releaseDate' => '2000-05-05',
                'duration' => 155,
                'rating' => 8.5,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/ty8TGRuvJLPUmAR1H1nRIsgwvim.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=owK1qxDselE', // placeholder
                'genres' => ['Action', 'Drame', 'Aventure']
            ],
            [
                'title' => 'The Lord of the Rings: The Fellowship of the Ring',
                'synopsis' => 'Dans un monde fantastique, un hobbit se lance dans un périple pour détruire un anneau maléfique.',
                'releaseDate' => '2001-12-19',
                'duration' => 178,
                'rating' => 8.8,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/6oom5QYQ2yQTMJIbnvbkBL9cHo6.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=V75dMMIW2B4', // placeholder
                'genres' => ['Fantastique', 'Aventure']
            ],
            [
                'title' => 'Harry Potter and the Sorcerer\'s Stone',
                'synopsis' => 'Un jeune garçon découvre qu’il est un sorcier et part étudier à l’école de magie Poudlard.',
                'releaseDate' => '2001-11-16',
                'duration' => 152,
                'rating' => 7.6,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/6wjpduH4SiU6bdL0rzkMks3DDJb.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=VyHV0BRtdxo', // placeholder
                'genres' => ['Fantastique', 'Aventure']
            ],
            [
                'title' => 'The Dark Knight',
                'synopsis' => 'Batman doit arrêter le Joker, un criminel anarchiste qui sème le chaos dans Gotham.',
                'releaseDate' => '2008-07-18',
                'duration' => 152,
                'rating' => 9.0,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/qJ2tW6WMUDux911r6m7haRef0WH.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=EXeTwQWrcwY', // placeholder
                'genres' => ['Action', 'Crime', 'Drame']
            ],
            [
                'title' => 'Inception',
                'synopsis' => 'Un voleur spécialisé dans l’infiltration des rêves se voit confier la mission d’implanter une idée dans l’esprit d’un homme.',
                'releaseDate' => '2010-07-16',
                'duration' => 148,
                'rating' => 8.8,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/edv5CZvWj09upOsy2Y6IwDhK8bt.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=YoHD9XEInc0', // placeholder
                'genres' => ['Science-Fiction', 'Action', 'Thriller']
            ],
            [
                'title' => 'Breaking Bad',
                'synopsis' => 'Un professeur de chimie devient fabricant de méthamphétamine après avoir appris qu’il est atteint d’un cancer, pour assurer l’avenir de sa famille.',
                'releaseDate' => '2008-01-20',
                'duration' => 49.9 * 60, // en minutes, ~ 49,9 h total → en minutes
                'rating' => 9.5,
                'type' => 'serie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/eSzpy96DwBujGFj0xMbXBcGcfxX.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=HhesaQXLuRY', // placeholder
                'genres' => ['Drame', 'Crime', 'Thriller']
            ],
            [
                'title' => 'Game of Thrones',
                'synopsis' => 'Des familles nobles se battent pour le contrôle du Trône de Fer tandis qu’une menace ancestrale surgit au-delà du Mur.',
                'releaseDate' => '2011-04-17',
                'duration' => 73 * 60, // estimation: total de ~73h → en minutes
                'rating' => 9.3,
                'type' => 'serie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/u3bZgnGQ9T01sWNhyveQz0wH0Hl.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=gcTkNV5Vg1E', // placeholder
                'genres' => ['Fantastique', 'Drame', 'Aventure']
            ],
            [
                'title' => 'Stranger Things',
                'synopsis' => 'Des enfants d’une petite ville découvrent des phénomènes surnaturels et une fillette dotée de pouvoirs étranges.',
                'releaseDate' => '2016-07-15',
                'duration' => 34 * 60, // estimation d’environ 34h total
                'rating' => 8.7,
                'type' => 'serie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/x2LSRK2Cm7MZhjluni1msVJ3wDF.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=b9EkMc79ZSU', // placeholder
                'genres' => ['Science-Fiction', 'Fantastique', 'Drame']
            ],
            [
                'title' => 'The Social Network',
                'synopsis' => 'L’histoire de la création de Facebook et des conflits entre ses fondateurs.',
                'releaseDate' => '2010-10-01',
                'duration' => 120,
                'rating' => 7.7,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/z4x0Bp48ar3Mda8KiPD1vwSY3D8.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=lB95KLmpLR4', // placeholder
                'genres' => ['Drame']
            ],
            [
                'title' => 'Mad Max: Fury Road',
                'synopsis' => 'Dans un monde post-apocalyptique, un guerrier et une femme rebelle fuient un tyran et tentent de survivre à travers le désert.',
                'releaseDate' => '2015-05-15',
                'duration' => 120,
                'rating' => 8.1,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/8tZYtuWezp8JbcsvHYO0O46tFbo.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=hEJnMQG9ev8', // placeholder
                'genres' => ['Action', 'Aventure', 'Science-Fiction']
            ],
            [
                'title' => 'La La Land',
                'synopsis' => 'Un musicien de jazz et une actrice en herbe tombent amoureux à Los Angeles, mais leurs rêves les séparent.',
                'releaseDate' => '2016-12-09',
                'duration' => 128,
                'rating' => 8.0,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/ylXCdC106IKiarftHkcacasaAcb.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=0pdqf4P9MB8', // placeholder
                'genres' => ['Drame', 'Comédie']
            ],
            [
                'title' => 'Interstellar',
                'synopsis' => 'Un groupe d’explorateurs spatiaux voyagent à travers un trou de ver dans l’espoir de trouver une nouvelle planète habitable.',
                'releaseDate' => '2014-11-07',
                'duration' => 169,
                'rating' => 8.6,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/rAiYTfKGqDCRIIqo664sY9XZIvQ.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=zSWdZVtXT7E', // placeholder
                'genres' => ['Science-Fiction', 'Aventure', 'Drame']
            ],
            [
                'title' => 'The Wolf of Wall Street',
                'synopsis' => 'La vie débridée d’un courtier en bourse new-yorkais, entre excès, fraude et luxe.',
                'releaseDate' => '2013-12-25',
                'duration' => 180,
                'rating' => 8.2,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/pWHf4khOloNVfCxscsXFj3jj6mD.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=iszwuX1AK6A', // placeholder
                'genres' => ['Drame', 'Comédie']
            ],
            [
                'title' => 'Inglourious Basterds',
                'synopsis' => 'Pendant la Seconde Guerre mondiale, un groupe de soldats juifs américains planifie d’assassiner des dirigeants nazis en France occupée.',
                'releaseDate' => '2009-08-21',
                'duration' => 153,
                'rating' => 8.3,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/7sfbEnaARXDDhKm0CZ7D7uc2sbo.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=KnrRy6kSFF0', // placeholder
                'genres' => ['Drame', 'Guerre', 'Aventure']
            ],
            [
                'title' => 'Avatar',
                'synopsis' => 'Sur la planète Pandora, un marine paralysé prend le contrôle d’un avatar pour comprendre les Na’vi et finit par choisir leur camp.',
                'releaseDate' => '2009-12-18',
                'duration' => 162,
                'rating' => 7.8,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/kXt5B5Tg8hH2zF4SiJ3WT47JceM.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=5PSNL1qE6VY', // placeholder
                'genres' => ['Science-Fiction', 'Aventure']
            ],
            [
                'title' => 'Black Panther',
                'synopsis' => 'Le roi du Wakanda revient chez lui pour prendre sa place sur le trône mais doit faire face à de vieilles menaces.',
                'releaseDate' => '2018-02-16',
                'duration' => 134,
                'rating' => 7.3,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/uxzzxijgPIY7slzFvMotPv8wjKA.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=xjDjIWPwcPU', // placeholder
                'genres' => ['Action', 'Aventure', 'Fantastique']
            ],
            [
                'title' => 'Parasite',
                'synopsis' => 'Une famille pauvre s’introduit dans la vie d’une famille riche, mais leurs plans prennent une tournure inattendue.',
                'releaseDate' => '2019-05-30',
                'duration' => 132,
                'rating' => 8.6,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=5xH0HfJHsaY', // placeholder
                'genres' => ['Drame', 'Comédie', 'Mystère']
            ],
            [
                'title' => '1917',
                'synopsis' => 'Deux jeunes soldats britanniques reçoivent une mission impossible durant la Première Guerre mondiale : transmettre un message pour sauver des centaines de vies.',
                'releaseDate' => '2019-12-25',
                'duration' => 119,
                'rating' => 8.3,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/A6cD4nB0Y3AxM5CIJcrs6Egwf9p.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=YqNYrYUiMfg', // placeholder
                'genres' => ['Guerre', 'Drame', 'Aventure']
            ],
            [
                'title' => 'Joker',
                'synopsis' => 'Un homme marginalisé devient le célèbre criminel Joker dans une Gotham sombre.',
                'releaseDate' => '2019-10-04',
                'duration' => 122,
                'rating' => 8.4,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=zAGVQLHvwOY', // placeholder
                'genres' => ['Drame', 'Crime', 'Thriller']
            ],
            [
                'title' => 'The Mandalorian',
                'synopsis' => 'Un chasseur de primes solitaire dans les confins de la galaxie protège un jeune enfant mystérieux.',
                'releaseDate' => '2019-11-12',
                'duration' => 16 * 30, // 16 épisodes * ~30min = 480 min (~8h)
                'rating' => 8.8,
                'type' => 'serie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/sWgBv7LV2PRoQgkxwlibdGXKz1S.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=aOC8E8z_ifw', // placeholder
                'genres' => ['Science-Fiction', 'Aventure']
            ],
            [
                'title' => 'Stranger Things 2',
                'synopsis' => 'La deuxième saison : de nouveaux dangers et mystères surgissent dans la petite ville de Hawkins.',
                'releaseDate' => '2017-10-27',
                'duration' => 18 * 50, // env. 18 épisodes * ~50 min = 900 min
                'rating' => 8.6,
                'type' => 'serie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/x2LSRK2Cm7MZhjluni1msVJ3wDF.jpg', // même image que S1
                'videoUrl' => 'https://www.youtube.com/watch?v=YEGWC3BKbg4', // placeholder
                'genres' => ['Science-Fiction', 'Fantastique']
            ],
            [
                'title' => 'Black Mirror',
                'synopsis' => 'Anthologie dystopique : des histoires indépendantes explorant la technologie, la société et ses dérives.',
                'releaseDate' => '2011-12-04',
                'duration' => 22 * 60, // estimation: 22 épisodes * 60 min = 1320 min
                'rating' => 8.8,
                'type' => 'serie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/pHcu1W0LJH2jiH8f8zcLyQBMjXg.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=jDiYGjp9vBI', // placeholder
                'genres' => ['Science-Fiction', 'Drame', 'Mystère']
            ],
            [
                'title' => 'Avatar: The Last Airbender',
                'synopsis' => 'Un jeune garçon peut contrôler les éléments et doit sauver le monde des forces destructrices de la Nation du Feu.',
                'releaseDate' => '2005-02-21',
                'duration' => 61 * 23, // 61 épisodes * ~23 min = 1403 min
                'rating' => 9.3,
                'type' => 'serie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/tkDp4Kte6u8FLW3jrzFvUKpkc7m.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=VNIDLyIeHBM', // placeholder
                'genres' => ['Fantastique', 'Aventure', 'Action']
            ],
            [
                'title' => 'The Crown',
                'synopsis' => 'La vie de la reine Élisabeth II et les événements marquants de son règne.',
                'releaseDate' => '2016-11-04',
                'duration' => 40 * 55, // estimation: 40 épisodes * ~55 min = 2200 min
                'rating' => 8.7,
                'type' => 'serie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/qZSU5y5LqbvF7YVf5TsYwo6EDx6.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=JWtnJjn6ng0', // placeholder
                'genres' => ['Drame', 'Histoire']
            ],
            [
                'title' => 'Parasite',
                'synopsis' => 'Une famille pauvre s’infiltre dans la vie d’une famille riche, mais les choses tournent mal.',
                'releaseDate' => '2019-05-30',
                'duration' => 132,
                'rating' => 8.6,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=5xH0HfJHsaY',
                'genres' => ['Drame', 'Comédie', 'Mystère']
            ],
            [
                'title' => 'Joker',
                'synopsis' => 'Un comédien raté sombre dans la folie et devient le célèbre antagoniste du Chevalier Noir.',
                'releaseDate' => '2019-10-04',
                'duration' => 122,
                'rating' => 8.4,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=zAGVQLHvwOY',
                'genres' => ['Drame', 'Crime', 'Thriller']
            ],
            [
                'title' => 'Avengers: Endgame',
                'synopsis' => 'Les Avengers restants se réunissent pour renverser Thanos et restaurer l’ordre dans l’univers.',
                'releaseDate' => '2019-04-26',
                'duration' => 181,
                'rating' => 8.4,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/or06FN3Dka5tukK1e9sl16pB3iy.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=TcMBFSGVi1c',
                'genres' => ['Action', 'Aventure', 'Science-Fiction']
            ],
            [
                'title' => 'Dune',
                'synopsis' => 'Sur la planète désertique Arrakis, un jeune homme devient le pivot d’une lutte pour le contrôle de l’épice la plus précieuse de l’univers.',
                'releaseDate' => '2021-10-22',
                'duration' => 155,
                'rating' => 8.3,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/8PlKhEsClsg5Hfo7vRlFOeMBcZV.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=n9xhJrPXop4',
                'genres' => ['Science-Fiction', 'Aventure']
            ],
            [
                'title' => 'The Witcher',
                'synopsis' => 'Geralt de Riv, un chasseur de monstres solitaire, lutte pour trouver sa place dans un monde où les humains sont souvent plus vicieux que les bêtes.',
                'releaseDate' => '2019-12-20',
                'duration' => 8 * 58, // 8 épisodes saison 1, ~58 min
                'rating' => 8.2,
                'type' => 'serie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/zrPpUlehQaBf8YX2NrVrKK8IEpf.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=ndl1W4ltcmg',
                'genres' => ['Fantastique', 'Drame', 'Action']
            ],
            [
                'title' => 'Squid Game',
                'synopsis' => 'Des centaines de joueurs désespérés participent à des jeux mortels pour gagner une énorme somme d’argent.',
                'releaseDate' => '2021-09-17',
                'duration' => 9 * 55, // 9 épisodes de ~55 min
                'rating' => 8.0,
                'type' => 'serie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/eiU1iUV9j74LgFf1fUAJC2uaWih.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=oqxAJKy0ii4',
                'genres' => ['Thriller', 'Drame', 'Crime']
            ],
            [
                'title' => 'Jujutsu Kaisen',
                'synopsis' => 'Un lycéen chasse des malédictions après avoir ingéré un objet dangereux, devenant lui-même une malédiction puissante.',
                'releaseDate' => '2020-10-03',
                'duration' => 24 * 24, // estimation: 24 épisodes * ~24 min = 576 min
                'rating' => 8.7,
                'type' => 'serie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/3pzmYjf2qpruDGksQh0u0b3uVPr.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=VNkja_pX9W4',
                'genres' => ['Fantastique', 'Action']
            ],
            [
                'title' => 'Chernobyl',
                'synopsis' => 'Reconstitution de la catastrophe nucléaire de Tchernobyl et de ses conséquences humaines et politiques.',
                'releaseDate' => '2019-05-06',
                'duration' => 5 * 60, // 5 épisodes d’environ 60 min = 300 min
                'rating' => 9.4,
                'type' => 'serie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/zEUpZfQBPRBDWSPj8ejj1w4wPSR.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=s9APLXM9Ei8',
                'genres' => ['Drame', 'Histoire']
            ],
            [
                'title' => 'The Irishman',
                'synopsis' => 'Un tueur à gages de la mafia repense à sa vie quand il découvre qu’un de ses anciens amis est impliqué dans la disparition de Jimmy Hoffa.',
                'releaseDate' => '2019-11-01',
                'duration' => 209,
                'rating' => 7.8,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/6JYIGclVQdwNhnEzKI37qap6Gdt.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=WHXxVmeGQUc',
                'genres' => ['Drame', 'Crime']
            ],
            [
                'title' => 'Tenet',
                'synopsis' => 'Un agent secret manipule le temps pour empêcher une guerre mondiale, en inversant la causalité des objets et des événements.',
                'releaseDate' => '2020-08-26',
                'duration' => 150,
                'rating' => 7.4,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/k68nPLbIST6NP96JmTxmZijEvCA.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=L3pk_TBkihU',
                'genres' => ['Science-Fiction', 'Action', 'Thriller']
            ],
            [
                'title' => 'Everything Everywhere All at Once',
                'synopsis' => 'Une femme réalise qu’elle peut voyager entre des univers parallèles pour sauver le multivers avec sa famille.',
                'releaseDate' => '2022-03-25',
                'duration' => 139,
                'rating' => 8.1,
                'type' => 'movie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/8F0EoD3ByMKX6gX82J5Rie0Vl2R.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=wxN1T1uxQ2g',
                'genres' => ['Fantastique', 'Aventure', 'Action']
            ],
            [
                'title' => 'The Mandalorian S2',
                'synopsis' => 'La deuxième saison du chasseur de primes Mandalorien alors qu’il protège l’Enfant contre de nouveaux ennemis.',
                'releaseDate' => '2020-10-30',
                'duration' => 16 * 37, // estimation: 16 épisodes * ~37 min = 592 min
                'rating' => 8.6,
                'type' => 'serie',
                'imageUrl' => 'https://image.tmdb.org/t/p/original/sWgBv7LV2PRoQgkxwlibdGXKz1S.jpg',
                'videoUrl' => 'https://www.youtube.com/watch?v=bYek5zJHQBM',
                'genres' => ['Science-Fiction', 'Aventure']
            ],
        ];

        foreach ($items as $data) {
            $media = new Movie();
            $media->setTitle($data['title']);
            $media->setSynopsis($data['synopsis']);
            $media->setReleaseDate(new \DateTime($data['releaseDate']));
            $media->setDuration($data['duration']);
            $media->setRating($data['rating']);
            $media->setType($data['type'] === "movie" ? MovieType::MOVIE : MovieType::SERIE);
            $media->setImageUrl($data['imageUrl']);
            $media->setVideoUrl($data['videoUrl']);

            foreach ($data['genres'] as $gName) {
                if (isset($genres[$gName])) {
                    $media->addGenre($genres[$gName]);
                }
            }

            $manager->persist($media);
        }

        $manager->flush();
    }
}
