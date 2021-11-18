<?php

namespace Kameli\MailcoachSparkpostFeedback;

use Illuminate\Support\Arr;
use Spatie\Mailcoach\Domain\Campaign\Events\WebhookCallProcessedEvent;
use Spatie\Mailcoach\Domain\Shared\Models\Send;
use Spatie\Mailcoach\Domain\Shared\Support\Config;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\ProcessWebhookJob;

class ProcessSparkpostWebhookJob extends ProcessWebhookJob
{
    public function __construct(WebhookCall $webhookCall)
    {
        parent::__construct($webhookCall);

        $this->queue = config('mailcoach.campaigns.perform_on_queue.process_feedback_job');

        $this->connection = $this->connection ?? Config::getQueueConnection();
    }

    public function handle()
    {
        $payload = $this->webhookCall->payload;

        $payload = array_map(function ($rawEvent) {
            return $this->handleRawEvent($rawEvent);
        }, $payload);

        $this->webhookCall->update(['payload' => array_filter($payload)]);

        event(new WebhookCallProcessedEvent($this->webhookCall));
    }

    protected function handleRawEvent(array $rawEvent): ?array
    {
        if (! $send = $this->getSend($rawEvent)) {
            return null;
        }

        $sparkpostEvent = SparkpostEventFactory::createForPayload($rawEvent);
        $sparkpostEvent->handle($send);

        return $rawEvent;
    }

    protected function getSend(array $rawEvent): ?Send
    {
        $eventType = array_key_first($rawEvent['msys']);
        $transportId = Arr::get($rawEvent, "msys.{$eventType}.transmission_id");

        if (! $transportId) {
            return null;
        }

        return Send::findByTransportMessageId($transportId);
    }
}
