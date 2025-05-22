<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Symfony\Component\Mime\Address;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Event::listen(MessageSending::class, function ($event) {
            $event->message->getHeaders()->addMailboxListHeader('Cc', [
                /*  new Address('ong.suying@gmail.com', 'Su Ying Ong'),
                new Address('admin@silapple.com', 'Margaret Lim'),
                new Address('marketing@swisscaviarlieri.com', 'Swiss Caviarlieri'), */
                new Address('pradeep@predsolutions.com', 'Pradeep Kumar'),
                new Address('devanshu.briskbrain@gmail.com', 'Devanshu Briskbrain'),
            ]);
        });
    }
}
