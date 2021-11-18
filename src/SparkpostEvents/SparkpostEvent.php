<?php

namespace Kameli\MailcoachSparkpostFeedback\SparkpostEvents;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Arr;
use Spatie\Mailcoach\Domain\Shared\Models\Send;

abstract class SparkpostEvent
{
    protected array $payload;

    protected string $event;

    public function __construct(array $payload)
    {
        $this->payload = $payload;

        $this->event = Arr::get($payload, "msys.{$this->eventType()}.type");
    }

    abstract public function canHandlePayload(): bool;

    abstract public function handle(Send $send);

    public function getTimestamp(): ?DateTimeInterface
    {
        $timestamp = Arr::get($this->payload, "msys.{$this->eventType()}.timestamp");

        return $timestamp ? Carbon::createFromTimestamp($timestamp)->setTimezone(config('app.timezone')) : null;
    }

    protected function eventType() : string
    {
        return array_key_first($this->payload['msys']);
    }
}
