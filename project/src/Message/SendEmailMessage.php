<?php

namespace App\Message;

final class SendEmailMessage
{
    /*
     * Add whatever properties & methods you need to hold the
     * data for this message class.
     */

    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

   public function getContent(): string
   {
       return $this->content;
   }
}
