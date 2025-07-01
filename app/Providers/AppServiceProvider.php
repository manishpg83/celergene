<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mime\Address;
use App\Notifications\FrontResetPasswordNotification;
use App\Mail\PaymentReminderMail;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        Event::listen(MessageSending::class, function ($event) {
            if (env('APP_ENVIRONMENT') !== 'local') {

                $addresses = [
                    new Address('ong.suying@gmail.com', 'Su Ying Ong'),
                    new Address('admin@silapple.com', 'Margaret Lim'),
                    new Address('marketing@celergenswiss.com', 'Celergen'),
                ];

                $mailableClass = $event->data['__laravel_mailable'] ?? null;

                if (!$mailableClass) {
                    // Log::info('No mailable class found in event');
                    return;
                }

                // Log::info("Processing mail: {$mailableClass}");

                if ($mailableClass === FrontResetPasswordNotification::class) {
                    // Log::info('Skipping password reset notification');
                    return;
                }

                $isPaymentReminder = $mailableClass === PaymentReminderMail::class;

                $headerType = $isPaymentReminder ? 'Bcc' : 'Cc';
                // Log::info("Adding {$headerType} for {$mailableClass}");

                $event->message->getHeaders()->addMailboxListHeader($headerType, $addresses);
            }
        });
    }
}
