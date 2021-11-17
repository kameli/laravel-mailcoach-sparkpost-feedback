<?php

namespace Kameli\MailcoachSparkpostFeedback;

use Kameli\MailcoachSparkpostFeedback\SparkpostEvents\ClickEvent;
use Kameli\MailcoachSparkpostFeedback\SparkpostEvents\ComplaintEvent;
use Kameli\MailcoachSparkpostFeedback\SparkpostEvents\OpenEvent;
use Kameli\MailcoachSparkpostFeedback\SparkpostEvents\OtherEvent;
use Kameli\MailcoachSparkpostFeedback\SparkpostEvents\BounceEvent;
use Kameli\MailcoachSparkpostFeedback\SparkpostEvents\SparkpostEvent;

class SparkpostEventFactory
{
    protected static array $sendgridEvents = [
        ClickEvent::class,
        ComplaintEvent::class,
        OpenEvent::class,
        BounceEvent::class,
    ];

    public static function createForPayload(array $payload): SparkpostEvent
    {
        $sendgridEvent = collect(static::$sendgridEvents)
            ->map(fn (string $sendgridEventClass) => new $sendgridEventClass($payload))
            ->first(fn (SparkpostEvent $sendgridEvent) => $sendgridEvent->canHandlePayload());

        return $sendgridEvent ?? new OtherEvent($payload);
    }
}
