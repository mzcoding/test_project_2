<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\V1;

use App\Services\TicketsGate\BookEvent;
use App\Services\TicketsGate\BookEventInterface;
use App\Services\TicketsGate\Dto\BookEventDto;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class BookEvenControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSuccess(): void
    {
        $name = 'Jhon';
        $availablePlaces = [51, 52];
        $eventId = 22;

        $uniqid = uniqid();

        $dto = new BookEventDto(true, $uniqid);

        $this->instance(
            BookEventInterface::class,
            Mockery::mock(BookEvent::class, static function (MockInterface $mock) use ($dto): void {
                $mock->shouldReceive('eventReserve')->once()
                    ->andReturn($dto);
            })
        );

        $response = $this->post('/api/v1/events/'. $eventId .'/reserve', ['name' => $name, 'places' => $availablePlaces]);


        $response
            ->assertJson(['success' => true, 'reservationId' => $uniqid])
            ->assertStatus(200);
    }

    public function testFail(): void
    {
        $name = null;
        $availablePlaces = "String";
        $eventId = 22;

        $response = $this->post('/api/v1/events/'. $eventId .'/reserve', ['name' => $name, 'places' => $availablePlaces]);

        $response
            ->assertStatus(302);
    }
}
