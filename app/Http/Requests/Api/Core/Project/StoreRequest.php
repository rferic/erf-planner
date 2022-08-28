<?php

namespace App\Http\Requests\Api\Core\Project;

class StoreRequest extends \Labelgrup\LaravelUtilities\Core\Requests\ApiRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(): array
	{
		return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date|date_format:Y-m-d',
            'client_id' => 'required|exists:clients,id',
            'status_id' => 'required|exists:statuses,id'
		];
	}
}
