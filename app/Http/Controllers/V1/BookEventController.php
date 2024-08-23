<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookEventRequest;
use App\Services\TicketsGate\BookEventInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

use OpenApi\Annotations as OA;

final class BookEventController extends Controller
{
    /**
     * @OA\POST (
     *     path="/events/{id}/reserve",
     *     summary="Reserve place ",
     *     tags={"Places"},
     *     description="Reserve place",
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
    public function __invoke(BookEventRequest $request, int $id, BookEventInterface $bookEvent): JsonResponse
    {
        try {
            $bookEventDto = $bookEvent->eventReserve($id, $request->validated('name'), $request->getPlaces());

            return response()->json($bookEventDto);
        } catch( \Throwable $exception ) {
            Log::error("BookEvent controller exception: " . $exception->getMessage(), $exception->getTrace());

            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
