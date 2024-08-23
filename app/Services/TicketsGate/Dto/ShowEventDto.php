<?php

declare(strict_types=1);

namespace App\Services\TicketsGate\Dto;


use Carbon\CarbonInterface;

final readonly class ShowEventDto
{
   public function __construct(
       public  int $id,
       public  int $showId,
       public  CarbonInterface $date
   ) {}
}
