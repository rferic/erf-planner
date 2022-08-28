<?php

namespace App\Http\Requests\Api\Core\Client;

use App\Models\Core\Client;
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
            'name' => 'required|string|max:255|unique:clients',
            'email' => 'required|string|email|max:255|unique:clients',
            'phone' => 'required|string|max:20',
            'web' => 'required|string|url',
            'status_id' => 'required|numeric|exists:statuses,id,deleted_at,NULL'
        ];
    }
}
