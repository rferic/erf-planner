<?php

use App\Models\Core\Language;
use Illuminate\Support\Facades\Cache;

if (!function_exists('translatable_languages')) {
    function translatable_languages(): array
    {
        return Cache::remember(Language::TRANSLATABLE_LANGUAGES_CACHE, now()->addMonth(), static function () {
            $languages = \App\Helpers\Core\LanguageHelper::getEnabled();
            return $languages->pluck('name', 'iso_code')->toArray();
        });
    }
}
