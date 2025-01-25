<?php

namespace App\Core;

class Sanitizer
{
    /**
     * Sanitize input data based on rules.
     *
     * @param array $data
     * @param array $rules
     * @return array
     */
    public static function sanitize(array $data, array $rules): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            if (isset($rules[$key])) {
                foreach ($rules[$key] as $rule) {
                    $value = self::applyRule($value, $rule);
                }
            } else {
                $value = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8'); // Default sanitization
            }

            $sanitized[$key] = $value;
        }

        return $sanitized;
    }

    /**
     * Apply a specific sanitization rule to a value.
     *
     * @param mixed $value
     * @param string $rule
     * @return mixed
     */
    private static function applyRule($value, string $rule)
    {
        switch ($rule) {
            case 'email':
                return filter_var($value, FILTER_SANITIZE_EMAIL);
            case 'url':
                return filter_var($value, FILTER_SANITIZE_URL);
            case 'integer':
                return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            case 'float':
                return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            case 'string':
                return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
            default:
                throw new \Exception("Unknown sanitization rule: $rule");
        }
    }
}
