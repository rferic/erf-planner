<?php

namespace App\Http\Requests\Api\Core\Auth;

use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;

class LoginRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'nullable|boolean'
        ];
    }
}
