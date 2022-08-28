<?php

namespace App\Helpers\Core;

use App\Models\Core\Project;

class ProjectHelper
{
   public static function validateAccess(Project $project, int $user_id, array $types): bool
    {
        return $project->users()->where('user_id', $user_id)->whereIn('type', $types)->exists();
    }
}
