<?php

namespace App\UseCases\Core\Project;

use App\Models\Core\Project;

class AttachUserUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected \App\Models\Core\Project $project,
        protected \App\Models\Core\User $user,
        protected string $type
    )
    {}

	public function action(): Project
	{
		if (!in_array($this->type, Project::USER_TYPES, true)) {
            throw new \RuntimeException(__('Invalid type'));
        }

        if ($this->type !== 'manager' && $this->project->author_id === $this->user->id) {
            throw new \RuntimeException(__('You can not change the author of the project'));
        }

        if ($this->project->users()->where('user_id', $this->user->id)->exists()) {
            $this->project->users()->updateExistingPivot($this->user->id, ['type' => $this->type]);
            return $this->response();
        }

        $this->project->users()->attach($this->user, ['type' => $this->type]);
        return $this->response();
	}

    private function response(): Project
    {
        $this->project->load('users');
        return $this->project;
    }
}
