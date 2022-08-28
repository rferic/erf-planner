<?php

namespace App\UseCases\Core\Project;

use App\Models\Core\Project;

class DetachUserUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected \App\Models\Core\Project $project,
        protected \App\Models\Core\User $user
    )
    {}

    public function action(): Project
    {
        if ($this->project->author_id === $this->user->id) {
            throw new \RuntimeException(__('You can not detach the author of the project'));
        }

        $this->project->users()->detach($this->user);
        $this->project->load('users');
        return $this->project;
    }
}
