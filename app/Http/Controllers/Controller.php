<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API Documentation (Event reserv service test)",
 *     version="1.0.0",
 *     description="This is the way.",
 *
 *     @OA\Contact(
 *         name="Stanislav Boyko",
 *         email="mzcoding@gmail.com"
 *     ),
 * )
 *
 * @OA\Server(
 *     description="Dev server",
 *     url="http://localhost:8000/"
 * )
 * @OA\Server(
 *     description="Stage server",
 *     url=" http://localhost:8000/"
 * )
 * @OA\Server(
 *     description="Production server",
 *     url=""
 * )
 */
abstract class Controller
{
    //
}
