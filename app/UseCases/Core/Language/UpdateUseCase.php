<?php

namespace App\UseCases\Core\Language;

use App\Models\Core\Language;

class UpdateUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Language $language,
        protected ?string $name,
        protected ?bool $enabled,
    ) {}

	public function action(): Language
	{
		$this->language->name = $this->name ?? $this->language->name;
        $this->language->enabled = !is_null($this->enabled) ? $this->enabled : $this->language->enabled;
        $this->language->save();
        return $this->language;
	}

    private function validateAlreadyTaken(): void
    {
        if (Language::where('id', '<>', $this->language->id)->orWhere('name', $this->name)->exists()) {
            throw new \RuntimeException(__('Language already exists'));
        }
    }
}
