<?php

namespace Kameli\MailcoachSparkpostFeedback;

use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile;

class SparkpostWebhookConfig
{
    public static function get(): WebhookConfig
    {
        $config = config('mailcoach.sparkpost_feedback');

        return new WebhookConfig([
            'name' => 'sparkpost-feedback',
            'signature_validator' => $config['signature_validator'] ?? SparkpostSignatureValidator::class,
            'webhook_profile' =>  $config['webhook_profile'] ?? ProcessEverythingWebhookProfile::class,
            'webhook_model' => $config['webhook_model'] ?? WebhookCall::class,
            'process_webhook_job' => $config['process_webhook_job'] ?? ProcessSparkpostWebhookJob::class,
        ]);
    }
}
