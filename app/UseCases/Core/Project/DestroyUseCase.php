<?php

namespace App\UseCases\Core\Project;

use App\Models\Core\Project;

class DestroyUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Project $project
    )
    {}

    public function action(): Project
    {
        try {
            $this->project->forceDelete();
        } catch (\Exception $e) {
            $this->project->delete();
        }

        return $this->project;
    }
}
