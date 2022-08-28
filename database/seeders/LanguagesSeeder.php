<?php

namespace Database\Seeders;

use App\Models\Core\Language;
use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
    public const DEFAULT_LANGUAGES = [
        [
            'name' => 'English',
            'iso_code' => 'en',
            'enabled' => true
        ],
        [
            'name' => 'Spanish',
            'iso_code' => 'es',
            'enabled' => true
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (self::DEFAULT_LANGUAGES as $language) {
            if (!Language::where('iso_code', $language['iso_code'])->exists()) {
                Language::create($language);
            }
        }
    }
}
