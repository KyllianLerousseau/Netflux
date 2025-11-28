<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Dto\RegisterDTO;
use App\Controller\RegisterController;

#[ApiResource(
    shortName: 'Register',
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    operations: [
        new Post(
            uriTemplate: '/register',
            controller: RegisterController::class,
            input: RegisterDTO::class,
            output: false
        )
    ]
)]
class RegisterResource {}