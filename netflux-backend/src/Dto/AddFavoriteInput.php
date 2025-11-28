<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class AddFavoriteInput
{
    #[Assert\NotBlank(message: "movie_id est requis")]
    #[Assert\Type('integer')]
    public ?int $movie_id = null;
}
