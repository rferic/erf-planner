<?php

namespace App\UseCases\Core\Project;

use App\Models\Core\Client;
use App\Models\Core\Project;
use App\Models\Core\Status;
use Carbon\Carbon;

class UpdateUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Project $project,
        protected string $name,
        protected ?string $description,
        protected ?Carbon $deadline,
        protected Client $client,
        protected Status $status
    )
    {}

	public function action(): Project
	{
        if ($this->status->type !== 'projects') {
            throw new \RuntimeException(__('Status not found'));
        }

        $this->project->name = $this->name;
        $this->project->description = $this->description;
        $this->project->deadline = $this->deadline;
        $this->project->client_id = $this->client->id;
        $this->project->status_id = $this->status->id;
        $this->project->save();
        return $this->project;
	}
}
