<?php

namespace Kameli\MailcoachSparkpostFeedback;

use Exception;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookProcessor;

class SparkpostWebhookController
{
    public function __invoke(Request $request)
    {
        $webhookConfig = SparkpostWebhookConfig::get();

        (new WebhookProcessor($request, $webhookConfig))->process();

        return response()->json(['message' => 'ok']);
    }
}
