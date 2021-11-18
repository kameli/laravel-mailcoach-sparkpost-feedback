<?php

namespace Kameli\MailcoachSparkpostFeedback\SparkpostEvents;

use Illuminate\Support\Arr;
use Spatie\Mailcoach\Domain\Shared\Models\Send;

class ClickEvent extends SparkpostEvent
{
    public function canHandlePayload(): bool
    {
        return $this->event === 'click';
    }

    public function handle(Send $send)
    {
        $url = Arr::get($this->payload, 'msys.track_event.target_link_url');

        if (! $url) {
            return;
        }

        $send->registerClick($url, $this->getTimestamp());
    }
}
