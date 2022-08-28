<?php

namespace App\Helpers\Core;

use App\Models\Core\Project;
use Symfony\Component\HttpFoundation\Response;

class ProjectHelper
{
    public static function validateAuthAccess(Project $project, array $types): void
    {
        abort_if(
            !auth()->check() || !self::validateAccess($project, auth()->id(), $types),
            Response::HTTP_UNAUTHORIZED,
            __('You have no permissions to attach user to this project')
        );
    }

    public static function validateAccess(Project $project, int $user_id, array $types): bool
    {
        return $project->users()->where('user_id', $user_id)->whereIn('type', $types)->exists();
    }
}
