<?php

namespace App\EventDispatchers\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\EventDispatchers\Events\CategoryIsUpdatedEvent;

class CategorySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            CategoryIsUpdatedEvent::NAME => 'onCategoryIsUpdated',
        ];
    }

    public function onCategoryIsUpdated(CategoryIsUpdatedEvent $event)
    {
        echo __METHOD__;
        $category = $event->getCategory();
        var_dump(['mode' => 'dispatch: event-subscriber', 'id' => $category->getId(), 'name' => $category->getName()]);
    }
}