<?php

namespace Kameli\MailcoachSparkpostFeedback;

use Illuminate\Http\Request;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class SparkpostSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        if ($request->getUser() !== env('SPARKPOST_WEBHOOK_USER') || $request->getPassword() !== env('SPARKPOST_WEBHOOK_PASSWORD')) {
            return false;
        }

        return true;
    }
}
