<?php

declare(strict_types=1);

namespace App\Services\TicketsGate\Dto;


final readonly class ShowDto
{
   public function __construct(
       public int $id,
       public string $name,
   ) {}
}
