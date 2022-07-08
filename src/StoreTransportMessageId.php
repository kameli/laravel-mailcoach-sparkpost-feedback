<?php

namespace Kameli\MailcoachSparkpostFeedback;

use Illuminate\Mail\Events\MessageSent;
use Spatie\Mailcoach\Domain\Shared\Models\Send;

class StoreTransportMessageId
{
    public function handle(MessageSent $event)
    {
        if (! $event->message->getHeaders()->has('X-SparkPost-Transmission-ID')) {
            return;
        }

        // Check if mail is tracked by Mailcoach
        if (! $event->message->getHeaders()->has('Message-ID')) {
            return;
        }

        $messageId = $event->message->getHeaders()->get('Message-ID')->getBodyAsString();

        if ($send = Send::findByTransportMessageId(trim($messageId, '><'))) {
            $transportMessageId = $event->message->getHeaders()->get('X-SparkPost-Transmission-ID')->getBodyAsString();
            $send->storeTransportMessageId($transportMessageId);
        }
    }
}
