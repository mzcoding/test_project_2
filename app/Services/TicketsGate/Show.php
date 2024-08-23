<?php

declare(strict_types=1);

namespace App\Services\TicketsGate;

use App\Services\TicketsGate\Dto\ShowDto;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class Show extends Client implements ShowInterface
{
    /**
     * @throws ConnectionException
     */
    public function shows(): Collection
    {
        $body = [];
        $response = Http::retry(3, 100)
            ->withToken($this->authToken)
            ->get($this->url . '/shows');

        if ($response->ok()) {
            $decodeBody = json_decode($response->body(), true);
            $body = $decodeBody['response'] ?? $decodeBody;
        }

        $collection = collect($body);
        // todo: add validation in the future
        return $collection->map(fn (array $item) => new ShowDto((int) $item['id'], $item['name']));
    }
}
