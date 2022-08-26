<?php

namespace App\Http\Requests\Api\Core\Role;

use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;

class UpdateRequest extends ApiRequest
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
            'name' => 'required|string|unique:roles,name,' . $this->route('role')->id,
        ];
    }
}
