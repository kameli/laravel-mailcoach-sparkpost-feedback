<?php

namespace Kameli\MailcoachSparkpostFeedback;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MailcoachSparkpostFeedbackServiceProvider extends ServiceProvider
{
    public function register()
    {
        Route::macro('sparkpostFeedback', fn (string $url) => Route::post($url, '\\' . SparkpostWebhookController::class));

        Event::listen(MessageSent::class, StoreTransportMessageId::class);
    }
}
