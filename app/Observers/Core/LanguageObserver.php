<?php

namespace App\Observers\Core;

use App\Models\Core\Language;
use Illuminate\Support\Facades\Cache;

class LanguageObserver
{
    /**
     * Handle the Language "created" event.
     *
     * @param  \App\Models\Core\Language  $language
     * @return void
     */
    public function created(Language $language): void
    {
        $language->is_enabled && $this->clearTranslatableLanguagesCache();
    }

    /**
     * Handle the Language "updated" event.
     *
     * @param  \App\Models\Core\Language  $language
     * @return void
     */
    public function updated(Language $language): void
    {
        $language->isDirty('enabled') && $this->clearTranslatableLanguagesCache();
    }

    /**
     * Handle the Language "deleted" event.
     *
     * @param  \App\Models\Core\Language  $language
     * @return void
     */
    public function deleted(Language $language): void
    {
        $language->is_enabled && $this->clearTranslatableLanguagesCache();
    }

    /**
     * Handle the Language "restored" event.
     *
     * @param  \App\Models\Core\Language  $language
     * @return void
     */
    public function restored(Language $language): void
    {
        $language->is_enabled && $this->clearTranslatableLanguagesCache();
    }

    /**
     * Handle the Language "force deleted" event.
     *
     * @param  \App\Models\Core\Language  $language
     * @return void
     */
    public function forceDeleted(Language $language): void
    {
        //
    }

    private function clearTranslatableLanguagesCache(): void
    {
        Cache::forget(Language::TRANSLATABLE_LANGUAGES_CACHE);
    }
}
