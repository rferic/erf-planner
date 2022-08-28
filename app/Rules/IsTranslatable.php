<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class IsTranslatable implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail): void
    {
        if (!is_array($value)) {
            $fail('The ' . $attribute . ' must be an translatable array.');
            return;
        }

        foreach (array_keys(translatable_languages()) as $language) {
            if (!array_key_exists($language, $value)) {
                $fail('The ' . $attribute . ' must contain a "' . $language . '" iso code.');
            } else if (!is_string($value[$language]) && !empty($value[$language])) {
                $fail('The ' . $attribute . '.' . $language . ' must be a string.');
            }
        }
    }
}
