<?php

namespace App\Http\Requests\Api\Core\Project;

use App\Models\Core\Project;

class AttachUserRequest extends \Labelgrup\LaravelUtilities\Core\Requests\ApiRequest
{
	use ValidateAccess;

    public const USER_TYPES = ['manager'];

    /**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(): array
	{
		return [
			'type' => 'required|in:' . implode(',', Project::USER_TYPES)
		];
	}
}
