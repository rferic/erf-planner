<?php

namespace App\Http\Requests\Api\Core\User;

use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;
use Labelgrup\LaravelUtilities\Helpers\Password;

class UpdateRequest extends ApiRequest
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
            'email' => 'nullable|string|email|unique:users,email,' . auth()->id(),
            'name' => 'nullable|string|max:255',
            'password' => [
                'nullable',
                'string',
                Password::rule(12)
            ],
            'role' => 'nullable|string|exists:roles,name'
        ];
    }
}
