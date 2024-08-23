<?php

declare(strict_types=1);

namespace App\Services\TicketsGate;


use Illuminate\Support\Collection;

interface EventItemInterface
{
   public function getPlaces(int $eventId): Collection;
}
