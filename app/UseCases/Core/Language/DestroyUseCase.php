<?php

namespace App\UseCases\Core\Language;

use App\Models\Core\Language;

class DestroyUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Language $language,
    ) {}

	public function action(): Language
	{
        try {
            $this->language->forceDelete();
        } catch (\Exception $_) {
            $this->language->delete();
        }
		
        return $this->language;
	}
}
