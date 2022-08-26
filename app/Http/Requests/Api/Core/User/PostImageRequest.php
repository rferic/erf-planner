<?php

namespace App\Http\Requests\Api\Core\User;

use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;

class PostImageRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
