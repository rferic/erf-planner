<?php

namespace App\Http\Requests\Api\Core\User;

use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;
use Labelgrup\LaravelUtilities\Helpers\Password;

class StoreRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => [
                'required',
                'string',
                Password::rule(12)
            ],
            'role' => 'nullable|string|exists:roles,name'
        ];
    }
}
