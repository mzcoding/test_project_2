<?php

declare(strict_types=1);

namespace App\Services\TicketsGate;


use App\Services\TicketsGate\Dto\BookEventDto;

interface BookEventInterface
{
   public function eventReserve(int $eventId, string $name, array $places): BookEventDto;
}
