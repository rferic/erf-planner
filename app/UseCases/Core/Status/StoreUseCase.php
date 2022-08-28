<?php

namespace App\UseCases\Core\Status;

use App\Models\Core\Status;

class StoreUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected array $name,
        protected string $color,
        protected string $text_color,
        protected string $type,
        protected bool $is_started,
        protected bool $is_ended,
        protected int $weight
    ) {
    }

	public function action(): Status
	{
		return Status::create([
            'name' => $this->name,
            'color' => $this->color,
            'text_color' => $this->text_color,
            'type' => $this->type,
            'is_started' => $this->is_started,
            'is_ended' => $this->is_ended,
            'weight' => $this->weight
        ]);
	}
}
