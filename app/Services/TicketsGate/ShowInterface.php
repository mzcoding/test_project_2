<?php

declare(strict_types=1);

namespace App\Services\TicketsGate;


use Illuminate\Support\Collection;

interface ShowInterface
{
   public function shows(): Collection;
}
