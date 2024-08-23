<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\TicketsGate\Dto\ShowDto;
use App\Services\TicketsGate\ShowInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use OpenApi\Annotations as OA;

final class ShowController extends Controller
{
    /**
     * @OA\GET (
     *     path="/api/v1/shows",
     *     summary="List all shows ",
     *     tags={"Shows"},
     *     description="Get all shows",
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
    public function __invoke(Request $request, ShowInterface $show): JsonResponse
    {
        try {
           $collection = $show->shows();

           return response()->json($collection->map(
               fn (ShowDto $showDto) => [
                   'id' => $showDto->id,
                   'name' => $showDto->name,
               ]
           ));

        } catch( \Throwable $exception ) {
            Log::error("Show controller exception: " . $exception->getMessage(), $exception->getTrace());

            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
