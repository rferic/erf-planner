<?php

namespace App\UseCases\Core\Status;

use App\Models\Core\Status;

class DestroyUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Status $status
    )
    {}

	public function action(): Status
	{
        $this->validateStatusNotUsed();

        try {
            $this->status->forceDelete();
        } catch (\Exception $_) {
            $this->status->delete();
        }

        return $this->status;
	}

    private function validateStatusNotUsed(): void
    {
        foreach (array_keys(Status::AVAILABLE_TYPES_CLASSES) as $type) {
            if ($this->status->$type()->count() > 0) {
                throw new \RuntimeException(__('This status is used in :type', ['type' => $type]));
            }
        }
    }
}
