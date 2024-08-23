<?php

declare(strict_types=1);

namespace App\Services\TicketsGate;

use App\Services\TicketsGate\Dto\ShowEventDto;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ShowEvent extends Client implements ShowEventInterface
{
    public function getEvents(int $showId): Collection
    {
        $body = [];
        $response = Http::retry(3, 100)
            ->withToken($this->authToken)
            ->get($this->url . '/shows/' . $showId . '/events');

        if ($response->ok()) {
            $decodeBody = json_decode($response->body(), true);
            $body = $decodeBody['response'] ?? $decodeBody;
        }

        $collection = collect($body);
        return $collection->map(fn (array $item) => new ShowEventDto(
            (int) $item['id'],
            $item['showId'],
            CarbonImmutable::createFromTimestamp(strtotime($item['date']))
        ));
    }
}
