<?php

namespace App\Http\Requests\Api\Core\Project;

use App\Helpers\Core\ProjectHelper;
use App\Models\Core\Project;

trait ValidateAccess
{
    public function authorize(): bool
    {
        $project = $this->route('project');

        return auth()->check() &&
            is_a($project, Project::class) &&
            ProjectHelper::validateAccess($project, auth()->id(), self::USER_TYPES);
    }

    public function rules(): array
    {
        return [];
    }
}
