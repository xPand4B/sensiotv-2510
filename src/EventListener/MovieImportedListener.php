<?php

namespace App\EventListener;

use App\Entity\Movie;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class MovieImportedListener
{
    public function postPersist(LifecycleEventArgs $event): void
    {
        /** @var Movie $movie */
        $movie = $event->getObject();

        // Put your logic here before or after a DB change occured inside an entity like:
        // - Log column change
        // - Send a notification / email each time an entity is added into DB
        // - ...

        $userToNotify = [
            'me@you.com'
        ];

        $email = [
            'from' => 'info@sensioTV.io',
            'to' => implode(',', $userToNotify),
            'subject' => 'Hello there, '.$movie->getTitle().' has been imported',
            'body' => 'Watch it now by visiting https://www.imdb.com/title/'.$movie->getImdbId().'/',
        ];

        dump($email);
    }
}