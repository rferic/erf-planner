<?php

namespace App\Http\Requests\Api\Core\Role;

use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;

class SyncPermissionsRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->route('role')?->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name'
        ];
    }
}
