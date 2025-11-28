<?php

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class PasswordMatch extends Constraint
{
    public string $message = 'Les mots de passe ne correspondent pas.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
