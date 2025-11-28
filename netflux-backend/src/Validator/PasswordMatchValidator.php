<?php

namespace App\Validator;

use App\Dto\RegisterDTO;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordMatchValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$value instanceof RegisterDTO) {
            return;
        }

        if ($value->password !== $value->confirmPassword) {
            $this->context->buildViolation($constraint->message)
                ->atPath('confirmPassword')
                ->addViolation();
        }
    }
}
