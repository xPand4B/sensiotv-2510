<?php

namespace App\EventSubscriber;

use App\Event\UserRegisteredEvent;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserRegisteredSubscriber implements EventSubscriberInterface
{
    #[ArrayShape(['user_registered' => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            'user_registered' => 'onUserRegistration',
        ];
    }

    public function onUserRegistration(UserRegisteredEvent $event): void
    {
        $user = $event->getUser();

        dump($user);
    }
}
