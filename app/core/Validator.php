<?php

namespace App\Core;

class Validator
{
    protected array $errors = [];
    protected array $validatedData = [];

    /**
     * Validate data against rules.
     *
     * @param array $data
     * @param array $rules
     * @return void
     */
    public function validate(array $data, array $rules): void
    {
        foreach ($rules as $field => $ruleString) {
            $rulesArray = explode('|', $ruleString);
            $value = $data[$field] ?? null;

            // remove validated data form array
            unset($data[$field]);

            foreach ($rulesArray as $rule) {
                [$ruleName, $ruleParam] = explode(':', $rule . ':');

                if (!in_array('integer', $rulesArray) && ($ruleName == 'min' || $ruleName == 'max')) {
                    $this->applyRule($field, strlen($value), $rule);
                } else {
                    $this->applyRule($field, $value, $rule);
                }
            }

            if (!isset($this->errors[$field])) {
                $this->validatedData[$field] = $value;
            }
        }

        // add all other data into validated
        foreach ($data as $field => $value) {
            if (in_array($field, array('_csrf_token', '_method'))) {
                continue;
            }

            $this->validatedData[$field] = $value;
        }
    }

    /**
     * Apply a validation rule.
     *
     * @param string $field
     * @param mixed $value
     * @param string $rule
     * @return void
     */
    protected function applyRule(string $field, $value, string $rule): void
    {
        [$ruleName, $ruleParam] = explode(':', $rule . ':');

        switch ($ruleName) {
            case 'required':
                if (empty($value)) {
                    $this->addError($field, "This is required.");
                }
                break;

            case 'string':
                if (!is_string($value) && !empty($value)) {
                    $this->addError($field, "$field must be a string.");
                }
                break;

            case 'integer':
                if (!filter_var($value, FILTER_VALIDATE_INT) && !empty($value)) {
                    $this->addError($field, "$field must be an integer.");
                }
                break;

            case 'max':
                if ($value > (int) $ruleParam && !empty($value)) {
                    $this->addError($field, "$field must not exceed $ruleParam.");
                }
                break;

            case 'min':
                if ($value < (int) $ruleParam && !empty($value)) {
                    $this->addError($field, "$field must be at least $ruleParam.");
                }
                break;

            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL) && !empty($value)) {
                    $this->addError($field, "Must be a valid email address.");
                }
                break;

            case 'url':
                if (!filter_var($value, FILTER_VALIDATE_URL) && !empty($value)) {
                    $this->addError($field, "Must be a valid URL.");
                }
            case 'mobile':
                if (!preg_match('/^01\d{9}$/', $value) && !empty($value)) {
                    $this->addError($field, "Must be a valid mobile number.");
                }
                break;
        }
    }

    /**
     * Add a validation error.
     *
     * @param string $field
     * @param string $message
     * @return void
     */
    protected function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    /**
     * Check if validation passed.
     *
     * @return bool
     */
    public function passes(): bool
    {
        return empty($this->errors);
    }

    /**
     * Get validated data.
     *
     * @return array
     */
    public function getValidatedData(): array
    {
        return $this->validatedData;
    }

    /**
     * Get validation errors.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
