<?php

namespace App\Http\Requests\Api\Core\User;

use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;

class AssignRoleRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'role' => 'nullable|string|exists:roles,name'
        ];
    }
}
