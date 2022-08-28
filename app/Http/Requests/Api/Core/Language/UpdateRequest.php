<?php

namespace App\Http\Requests\Api\Core\Language;

use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;

class UpdateRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return $this->route('language')?->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|unique:languages,name,' . $this->route('language')->id . ',id,deleted_at,NULL',
            'enabled' => 'required|boolean'
        ];
    }
}
