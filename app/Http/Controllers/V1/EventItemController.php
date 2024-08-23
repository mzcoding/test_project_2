<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\TicketsGate\Dto\EventItemDto;
use App\Services\TicketsGate\EventItemInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use OpenApi\Annotations as OA;

final class EventItemController extends Controller
{
    /**
     * @OA\GET (
     *     path="/api/v1/events/{id}/places",
     *     summary="List all places by event id",
     *     tags={"Events"},
     *     description="Get all places",
     *     @OA\Parameter(
     *          description="Event id",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="int"),
     *          @OA\Examples(example="int", value="1", summary="An int value."),
     *      ),
     *     @OA\Response(
     *       response="200", description="Success result",
     *       @OA\JsonContent(
     *         allOf={
     *          @OA\Schema( ref="#/components/schemas/Body200" )
     *         }
     *       )
     *     )
     * )
     */
    public function __invoke(Request $request, int $id, EventItemInterface $eventItem): JsonResponse
    {
        try {
            $collection = $eventItem->getPlaces($id);

            return response()->json($collection->map(
                fn (EventItemDto $eventItemDto) => [
                    'id' => $eventItemDto->id,
                    'x' => $eventItemDto->x,
                    'y' => $eventItemDto->y,
                    'width' => $eventItemDto->width,
                    'height' => $eventItemDto->height,
                    'is_available' => $eventItemDto->isAvailable,
                ]
            ));

        } catch( \Throwable $exception ) {
            Log::error("EventItem controller exception: " . $exception->getMessage(), $exception->getTrace());

            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
