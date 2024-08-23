<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\V1;

use App\Services\TicketsGate\Dto\ShowEventDto;
use App\Services\TicketsGate\ShowEvent;
use App\Services\TicketsGate\ShowEventInterface;
use Carbon\CarbonImmutable;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ShowItemControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSuccess(): void
    {
        $id = 3;
        $showId = 5;
        $date = '2024-10-09 22:35:00';

        $id1 = 5;
        $showId1 = 10;
        $date1 = '2020-10-09 22:35:00';

        $collection = collect([
            ['id' => $id, 'showId' => $showId, 'date' => $date],
            ['id' => $id1, 'showId' => $showId1, 'date' => $date1],
        ]);

        $collection = $collection->map(fn (array $item) => new ShowEventDto(
            (int) $item['id'],
            $item['showId'],
            CarbonImmutable::createFromTimestamp(strtotime($item['date']))
        ));

        $this->instance(
            ShowEventInterface::class,
            Mockery::mock(ShowEvent::class, static function (MockInterface $mock) use ($collection): void {
                $mock->shouldReceive('getEvents')->once()
                    ->andReturn($collection);
            })
        );

        $response = $this->get('/api/v1/shows/'. $showId .'/events');

        $response
            ->assertJson($collection->map(
                fn (ShowEventDto $showEventDto) => [
                    'id' => $showEventDto->id,
                    'showId' => $showEventDto->showId,
                    'date' => $showEventDto->date->format('d.m.Y H:i'),
                ]
            )->toArray())
            ->assertStatus(200);
    }
}
