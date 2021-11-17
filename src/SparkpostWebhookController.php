<?php

namespace Kameli\MailcoachSparkpostFeedback;

use Exception;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookProcessor;

class SparkpostWebhookController
{
    public function __invoke(Request $request)
    {
        if ($request->getUser() !== 'kameli' || $request->getPassword() !== 'a2EQf0MlfyyofTtmlEqlm5EvPGe8dJ0JfDCjUy7P7Bi3eox1RSGyvKcw7XTM2c4k') {
            throw new Exception('Authentication failed');
        }

        $webhookConfig = SparkpostWebhookConfig::get();

        (new WebhookProcessor($request, $webhookConfig))->process();

        return response()->json(['message' => 'ok']);
    }
}
