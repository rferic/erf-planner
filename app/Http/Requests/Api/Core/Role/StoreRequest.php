<?php

namespace App\Http\Requests\Api\Core\Role;

use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;

class StoreRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:roles,name'
        ];
    }
}
