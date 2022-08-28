<?php

namespace App\Http\Requests\Api\Core\Project;

class PostImageRequest extends \Labelgrup\LaravelUtilities\Core\Requests\ApiRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(): array
	{
		return [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
		];
	}
}
