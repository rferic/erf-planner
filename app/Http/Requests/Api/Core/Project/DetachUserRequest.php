<?php

namespace App\Http\Requests\Api\Core\Project;

class DetachUserRequest extends \Labelgrup\LaravelUtilities\Core\Requests\ApiRequest
{
	use ValidateAccess;

    public const USER_TYPES = ['manager'];
}
