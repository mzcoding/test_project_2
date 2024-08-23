<?php

declare(strict_types=1);

namespace App\Services\TicketsGate\Dto;


final readonly class EventItemDto
{
   public function __construct(
       public int $id,
       public int $x,
       public int $y,
       public int $width,
       public int $height,
       public bool $isAvailable
   ) { }
}
