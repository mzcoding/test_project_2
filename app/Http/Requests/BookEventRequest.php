<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody(
 *      request="BookEventRequest",
 *       @OA\JsonContent(
 *          type="object",
 *          required={"name", "places"},
 *          @OA\Property( property="name", type="string", description="user name", example="Ivan")
 *      )
 * )
 */
class BookEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:100'],
            'places'   => ['required', 'array'],
            'places.*' => ['required', 'integer', 'min:1'],
        ];
    }

    public function getPlaces(): array
    {
        return $this->validated('places');
    }
}
