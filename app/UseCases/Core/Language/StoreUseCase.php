<?php

namespace App\UseCases\Core\Language;

use App\Models\Core\Language;

class StoreUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected string $name,
        protected string $isoCode,
        protected bool $enabled,
    ) {}

	public function action(): Language
	{
		$this->validateAlreadyTaken();

        return Language::create([
            'name' => $this->name,
            'iso_code' => $this->isoCode,
            'enabled' => $this->enabled,
        ]);
	}

    private function validateAlreadyTaken(): void
    {
        if (Language::where('iso_code', $this->isoCode)->orWhere('name', $this->name)->exists()) {
            throw new \RuntimeException(__('Language already exists'));
        }
    }
}
