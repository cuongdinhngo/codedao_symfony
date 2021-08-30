<?php
namespace App\EventDispatchers\Events;
 
use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\Category;

class CategoryIsUpdatedEvent extends Event
{
    const NAME = 'category.update';
 
    protected $category;

    protected $logger;
 
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
 
    public function getCategory()
    {
        return $this->category;
    }
}