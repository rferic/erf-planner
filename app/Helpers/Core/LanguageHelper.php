<?php

namespace App\Helpers\Core;

use App\Models\Core\Language;
use Illuminate\Support\Collection;

class LanguageHelper
{
    public static function getEnabled(): Collection
    {
        return Language::where('enabled', true)->get();
    }

    public static function getByIsoCode(string $isoCode): ?Language
    {
        return Language::where('iso_code', $isoCode)->first();
    }
}
