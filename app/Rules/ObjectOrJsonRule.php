<?php

namespace App\Rules;


use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ObjectOrJsonRule implements ValidationRule
{
    public function passes($value): bool
    {
        if (is_array($value) || is_object($value)) {
            return true;
        }

        if ($this->isJson($value)) {
            return true;
        }

        return false;
    }

    public function message(): string
    {
        return 'The :attribute must be a valid JSON string or an object.';
    }

    protected function isJson($value): bool
    {
        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->passes($value)){
            $fail($this->message());
        }
    }
}
