<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\EventDispatchers\Events\CategoryIsUpdatedEvent;

class ConferenceSubscriber implements EventSubscriberInterface
{
    public function onCategoryUpdate(CategoryIsUpdatedEvent $event)
    {
        // ...
    }

    public static function getSubscribedEvents()
    {
        return [
            'category.update' => 'onCategoryUpdate',
        ];
    }
}
