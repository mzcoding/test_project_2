<?php

declare(strict_types=1);

namespace App\Services\TicketsGate;


use App\Services\TicketsGate\Dto\EventItemDto;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class EventItem extends Client implements EventItemInterface
{
    /**
     * @throws ConnectionException
     */
    public function getPlaces(int $eventId): Collection
    {
        $body = [];
        $response = Http::retry(3, 100)
            ->withToken($this->authToken)
            ->get($this->url . '/events/' . $eventId . '/places');

        if ($response->ok()) {
            $decodeBody = json_decode($response->body(), true);
            $body = $decodeBody['response'] ?? $decodeBody;
        }

        $collection = collect($body);
        // todo: add validation in the future
        return $collection->where('is_available', '=', true)
            ->map(fn (array $item) => new EventItemDto(
            (int) $item['id'],
            $item['x'],
            $item['y'],
            $item['width'],
            $item['height'],
            (bool) $item['is_available'])
        );
    }
}
