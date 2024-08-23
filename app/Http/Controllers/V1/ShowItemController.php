<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\TicketsGate\Dto\ShowEventDto;
use App\Services\TicketsGate\ShowEventInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

final class ShowItemController extends Controller
{
    /**
     * @OA\GET (
     *     path="/api/v1/shows/{id}/events",
     *     summary="List events by show id",
     *     tags={"Events"},
     *     description="Get all events",
     *     @OA\Parameter(
     *          description="Show id",
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
    public function __invoke(Request $request, int $id, ShowEventInterface $showEvent): JsonResponse
    {
        try {
            $collection = $showEvent->getEvents($id);

            return response()->json($collection->map(
                fn (ShowEventDto $showEventDto) => [
                    'id' => $showEventDto->id,
                    'showId' => $showEventDto->showId,
                    'date' => $showEventDto->date->format('d.m.Y H:i'),
                ]
            ));

        } catch( \Throwable $exception ) {
            Log::error("Show Item controller exception: " . $exception->getMessage(), $exception->getTrace());

            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
