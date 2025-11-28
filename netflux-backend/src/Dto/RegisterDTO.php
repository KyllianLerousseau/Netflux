<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AppAssert;
use Symfony\Component\Serializer\Annotation\Groups;


#[AppAssert\PasswordMatch]
class RegisterDTO
{
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(message: "L'email n'est pas valide.")]
    #[Groups(['read', 'write'])]
    public string $email;

    #[Assert\NotBlank(message: "Le pseudo est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9]+$/",
        message: "Le pseudo ne peut contenir que des lettres et chiffres."
    )]
    #[Groups(['read', 'write'])]
    public string $pseudo;

    #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
        message: "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un symbole."
    )]
    #[Groups(['write'])]
    public string $password;

    #[Assert\NotBlank(message: "La confirmation du mot de passe est obligatoire.")]
    #[Groups(['write'])]
    public string $confirmPassword;

    public function __construct(
        string $email = '',
        string $pseudo = '',
        string $password = '',
        string $confirmPassword = ''
    ) {
        $this->email = $email;
        $this->pseudo = $pseudo;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }
}