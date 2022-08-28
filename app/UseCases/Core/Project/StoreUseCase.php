<?php

namespace App\UseCases\Core\Project;

use App\Models\Core\Client;
use App\Models\Core\Project;
use App\Models\Core\Status;
use App\Models\Core\User;
use Carbon\Carbon;

class StoreUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected string $name,
        protected ?string $description,
        protected ?Carbon $deadline,
        protected Client $client,
        protected Status $status,
        protected User $author
    )
    {}

	public function action(): Project
	{
		if ($this->status->type !== 'projects') {
            throw new \RuntimeException(__('Status not found'));
        }

        $project = Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'client_id' => $this->client->id,
            'status_id' => $this->status->id,
            'author_id' => $this->author->id
        ]);
        $this->attachAuthor($project);
        $project->load('users');
        return $project;
	}

    private function attachAuthor(Project $project): void
    {
        (new AttachUserUseCase($project, $this->author, 'manager'))->action();
    }
}
