<?php

namespace Kameli\MailcoachSparkpostFeedback\SparkpostEvents;

use Illuminate\Support\Arr;
use Spatie\Mailcoach\Domain\Shared\Models\Send;

class ComplaintEvent extends SparkpostEvent
{
    public function canHandlePayload(): bool
    {
        return $this->event === 'spam_complaint';
    }

    public function handle(Send $send)
    {
        $send->registerComplaint($this->getTimestamp());
    }
}
