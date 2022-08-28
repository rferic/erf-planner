<?php

namespace App\UseCases\Core\Status;

use App\Models\Core\Status;

class UpdateUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Status $status,
        protected ?array $name,
        protected ?string $color,
        protected ?string $text_color,
        protected ?bool $is_started,
        protected ?bool $is_ended,
        protected ?int $weight
    ) {
    }

	public function action(): Status
	{
		$this->status->name = $this->name ?? $this->status->name;
        $this->status->color = $this->color ?? $this->status->color;
        $this->status->text_color = $this->text_color ?? $this->status->text_color;
        $this->status->is_started = !is_null($this->is_started) ? $this->is_started : $this->status->is_started;
        $this->status->is_ended = !is_null($this->is_ended) ? $this->is_ended : $this->status->is_ended;
        $this->status->weight = !is_null($this->weight) ? $this->weight : $this->status->weight;
        $this->status->save();

        return $this->status;
	}
}
