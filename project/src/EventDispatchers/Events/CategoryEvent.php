<?php
namespace App\EventDispatchers\Events;
 
use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\Category;
use Psr\Log\LoggerInterface;

class CategoryEvent extends Event
{
    const NAME = 'category.created';
 
    protected $category;

    protected $logger;
 
    public function __construct(Category $category)
    {
        // $this->logger = $logger;
        $this->category = $category;
        // $this->logger->info(__METHOD__);
    }
 
    public function getCategory()
    {
        // $this->logger->info(__METHOD__);
        return $this->category;
    }
}