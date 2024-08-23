<?php

declare(strict_types=1);

namespace App\Services\TicketsGate\Dto;

final readonly class BookEventDto
{
    public function __construct(
        public bool $success,
        public string $reservationId
    ) {}
}
