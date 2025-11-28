<?php

namespace App\Controller;

use App\Dto\RegisterDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{
    public function __invoke(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $em
    ): JsonResponse {
        $dto = $serializer->deserialize(
            $request->getContent(),
            RegisterDTO::class,
            'json'
        );

        $errors = $validator->validate($dto);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json($errorMessages, 400);
        }

        if ($em->getRepository(User::class)->findOneBy(['email' => $dto->email])) {
            return $this->json(['email' => 'Cet email est déjà utilisé.'], 400);
        }
        if ($em->getRepository(User::class)->findOneBy(['pseudo' => $dto->pseudo])) {
            return $this->json(['pseudo' => 'Ce pseudo est déjà utilisé.'], 400);
        }

        $user = new User();
        $user->setEmail($dto->email);
        $user->setPseudo($dto->pseudo);
        $user->setPassword($hasher->hashPassword($user, $dto->password));
        $user->getRoles();

        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'Utilisateur enregistré avec succès.'], 201);
    }
}