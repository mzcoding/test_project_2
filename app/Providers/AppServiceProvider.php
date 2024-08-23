<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\TicketsGate\BookEvent;
use App\Services\TicketsGate\BookEventInterface;
use App\Services\TicketsGate\EventItem;
use App\Services\TicketsGate\EventItemInterface;
use App\Services\TicketsGate\Show;
use App\Services\TicketsGate\ShowEvent;
use App\Services\TicketsGate\ShowEventInterface;
use App\Services\TicketsGate\ShowInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ShowInterface::class, fn () => new Show(
            config('leadbook.url'),
            config('leadbook.api_key'),
        ));
        $this->app->bind(ShowEventInterface::class, fn () => new ShowEvent(
            config('leadbook.url'),
            config('leadbook.api_key'),
        ));
        $this->app->bind(EventItemInterface::class, fn () => new EventItem(
            config('leadbook.url'),
            config('leadbook.api_key'),
        ));
        $this->app->bind(BookEventInterface::class, fn () => new BookEvent(
            config('leadbook.url'),
            config('leadbook.api_key'),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
