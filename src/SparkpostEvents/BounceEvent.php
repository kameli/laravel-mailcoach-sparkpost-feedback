<?php

namespace Kameli\MailcoachSparkpostFeedback\SparkpostEvents;

use Illuminate\Support\Arr;
use Spatie\Mailcoach\Domain\Shared\Models\Send;

class BounceEvent extends SparkpostEvent
{
    public function canHandlePayload(): bool
    {
        return $this->event === 'bounce';
    }

    public function handle(Send $send)
    {
        $send->registerBounce($this->getTimestamp());
    }
}
