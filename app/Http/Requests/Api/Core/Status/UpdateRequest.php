<?php

namespace App\Http\Requests\Api\Core\Status;

use App\Models\Core\Status;
use App\Rules\IsTranslatable;
use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;

class UpdateRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                new IsTranslatable
            ],
            'color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'type' => 'required|string|in:' . implode(',', array_keys(Status::AVAILABLE_TYPES_CLASSES)),
            'is_started' => 'required|boolean',
            'is_ended' => 'required|boolean',
            'weight' => 'required|numeric'
        ];
    }
}
