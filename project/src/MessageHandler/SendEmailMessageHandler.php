<?php

namespace App\MessageHandler;

use App\Message\SendEmailMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Psr\Log\LoggerInterface;

final class SendEmailMessageHandler implements MessageHandlerInterface
{
    public $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;        
    }

    public function __invoke(SendEmailMessage $message)
    {
        $this->logger->info(__METHOD__);
        $this->logger->info($message->getContent());
    }
}
