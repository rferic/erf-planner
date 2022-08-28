<?php

namespace App\Http\Requests\Api\Core\Language;

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
            'name' => 'required|string|max:100|unique:languages,name,NULL,id,deleted_at,NULL',
            'iso_code' => 'required|string|max:10|unique:languages,iso_code,NULL,id,deleted_at,NULL',
            'enabled' => 'nullable|boolean'
        ];
    }
}
