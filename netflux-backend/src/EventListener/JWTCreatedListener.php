<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $user = $event->getUser();

        if (!$user instanceof User) {
            throw new \LogicException('User must be an instance of App\Entity\User');
        }

        $payload = $event->getData();
        $payload['id'] = $user->getId();
        $payload['email'] = $user->getEmail();
        $payload['pseudo'] = $user->getPseudo();
        $payload['roles'] = $user->getRoles();

        $event->setData($payload);
    }
}
