<?php

namespace App\MessageHandler;

use App\Message\GeneratePdfMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GeneratePdfMessageHandler{
    public function __invoke(GeneratePdfMessage $message)
    {
        // do something with your message
    }
}
