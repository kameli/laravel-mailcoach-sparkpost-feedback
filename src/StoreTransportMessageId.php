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

        if (! $send = Send::findByTransportMessageId($event->message->getId())) {
            return;
        }

        $transportMessageId = $event->message->getHeaders()->get('X-SparkPost-Transmission-ID')->getFieldBody();

        $send->storeTransportMessageId($transportMessageId);
    }
}
