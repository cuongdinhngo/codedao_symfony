<?php

namespace App\MessageHandler;

use App\Message\SmsNotification;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Psr\Log\LoggerInterface;

final class SmsNotificationHandler implements MessageHandlerInterface
{
    public $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;        
    }

    public function __invoke(SmsNotification $message)
    {
        $this->logger->info(__METHOD__);
        $this->logger->info($message->getContent());
    }
}
