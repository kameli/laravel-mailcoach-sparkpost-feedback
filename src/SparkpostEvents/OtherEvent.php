<?php

namespace Kameli\MailcoachSparkpostFeedback\SparkpostEvents;

use Spatie\Mailcoach\Domain\Shared\Models\Send;

class OtherEvent extends SparkpostEvent
{
    public function canHandlePayload(): bool
    {
        return true;
    }

    public function handle(Send $send)
    {
    }
}
