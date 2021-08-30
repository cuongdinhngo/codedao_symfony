<?php

namespace App\EventDispatchers\Listeners;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\EventDispatcher\Event;
 
class CategoryListener
{
    public function onCategoryIsCreatedEvent(Event $event)
    {
        $category = $event->getCategory();
        var_dump(['mode' => 'dispatch: event-listener','id' => $category->getId(), 'name' => $category->getName()]);
    }
}