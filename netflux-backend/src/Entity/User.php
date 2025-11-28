<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\FavoritesAddController;
use App\Controller\FavoritesDeleteController;
use App\Controller\FavoritesGetController;
use App\Dto\AddFavoriteInput;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(
    operations: [
        new GetCollection(
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Seul les admins peuvent accéder."
        ),
        new Get(
            security: "is_granted('ROLE_ADMIN') or object.getId() == user.getId()",
            securityMessage: "Seul les admins peuvent accéder."
        ),
        new Post(
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Seul les admins peuvent accéder."
        ),
        new Put(
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Seul les admins peuvent accéder."
        ),
        new Patch(
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Seul un admin peut modifier cet utilisateur.",
            denormalizationContext: ['groups' => ['user:patch']],
            validate: false
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Seul les admins peuvent accéder."
        ),
        new Get(
            name: 'get_user_favorites',
            uriTemplate: '/users/{id}/favorites',
            controller: FavoritesGetController::class,
            security: "is_granted('ROLE_USER') or object.getId() == user.getId()",
            securityMessage: "Vous n'êtes pas connecté."
        ),
        new Post(
            name: 'post_user_favorites',
            uriTemplate: '/users/{id}/favorites',
            controller: FavoritesAddController::class,
            input: AddFavoriteInput::class,
            security: "is_granted('ROLE_USER') or object.getId() == user.getId()",
            securityMessage: "Vous n'êtes pas connecté."
        ),
        new Delete(
            name: 'delete_user_favorite',
            uriTemplate: '/users/{id}/favorites/{movie_id}',
            controller: FavoritesDeleteController::class,
            security: "is_granted('ROLE_USER') or object.getId() == user.getId()",
            securityMessage: "Vous n'êtes pas connecté."

        ),
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(
        message: "L'email ne peut pas être vide.",
    )]
    #[Assert\Email(
        message: "L'email est invalide."
    )]
    #[Assert\Valid()]
    #[Groups(['user:read', 'user:write'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['user:read', 'user:write', 'user:patch'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(
        message: "Le mot de passe ne peut pas être vide."
    )]
    #[Assert\Regex(
        pattern: "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
        message: "Le mot de passe doit contenir une majuscule, un chiffre, un symbole et 8 caractères minimum."
    )]
    #[Groups(['user:write'])]
    private ?string $password = null;

    /**
     * @var Collection<int, Movie>
     */
    #[ORM\ManyToMany(targetEntity: Movie::class, inversedBy: 'users')]
    private Collection $favoris;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(
        message: "Le pseudo ne peut pas être vide."
    )]
    #[Assert\Length(
        min: 3,
        minMessage: "Pseudo trop court.",
        max: 20,
        maxMessage: "Pseudo trop long.",
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9]+$/",
        message: "Le nom d'utilisateur ne doit contenir que des lettres et chiffres."
    )]
    #[Groups(['user:read', 'user:write'])]
    private ?string $pseudo = null;

    public function __construct()
    {
        $this->favoris = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Movie $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
        }

        return $this;
    }

    public function removeFavori(Movie $favori): static
    {
        $this->favoris->removeElement($favori);

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }
}
