<?php

namespace App\Rules;


use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 *
 */
class ObjectOrJsonRule implements ValidationRule
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function passes(mixed $value): bool
    {
        if (is_array($value) || is_object($value)) {
            return true;
        }

        if ($this->isJson($value)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must be a valid JSON string or an object.';
    }

    /**
     * @param mixed $value
     * @return bool
     */
    protected function isJson(mixed $value): bool
    {
        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->passes($value)){
            $fail($this->message());
        }
    }
}
