<?php

namespace Kameli\MailcoachSparkpostFeedback\SparkpostEvents;

use Illuminate\Support\Arr;
use Spatie\Mailcoach\Domain\Shared\Models\Send;

class OpenEvent extends SparkpostEvent
{
    public function canHandlePayload(): bool
    {
        return $this->event === 'open';
    }

    public function handle(Send $send)
    {
        $send->registerOpen($this->getTimestamp());
    }
}
