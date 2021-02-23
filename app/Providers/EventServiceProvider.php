<?php

namespace App\Providers;

use App\Events\ArchiveNewProducts;
use App\Events\ArchiveUpdatedProducts;
use App\Listeners\ArchiveNewProducts as ListenersArchiveNewProducts;
use App\Listeners\ArchiveUpdatedProducts as ListenersArchiveUpdatedProducts;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ArchiveNewProducts::class => [
            ListenersArchiveNewProducts::class
        ],
        ArchiveUpdatedProducts::class => [
            ListenersArchiveUpdatedProducts::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
