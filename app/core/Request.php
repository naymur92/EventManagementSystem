<?php

namespace App\Core;

class Request
{
    private array $data = [];
    protected array $rules = [];
    private array $errors = [];
    private array $validatedData = [];
    protected ?Validator $validator = null;
    protected array $headers;

    public function __construct()
    {
        $this->data = $_REQUEST;
        $this->headers = getallheaders();
    }

    public function header($key, $default = null)
    {
        return $this->headers[$key] ?? $default;
    }

    /**
     * Define sanitization rules for input data.
     *
     * @param array $rules
     * @return void
     */
    public function setSanitizationRules(array $rules): void
    {
        $this->rules = $rules;
    }

    /**
     * Sanitize input data based on rules.
     *
     * @return array
     */
    public function sanitized(): array
    {
        return Sanitizer::sanitize($this->data, $this->rules);
    }

    /**
     * Get all sanitized input data.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->sanitized();
    }

    /**
     * Get a specific input value (sanitized).
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function input(string $key, $default = null)
    {
        $sanitized = $this->sanitized();
        return $sanitized[$key] ?? $default;
    }

    /**
     * Validate the request data.
     *
     * @param array $rules
     * @return boolean
     */
    public function validate(array $rules): bool
    {
        // first sanitize data
        $this->data = Sanitizer::sanitize($this->data, $this->rules);

        $this->validator = new Validator();
        $this->validator->validate($this->data, $rules);
        return $this->validator->passes();
    }

    /**
     * Get validated data.
     *
     * @return array
     * @throws \Exception
     */
    public function validated(): array
    {
        if ($this->validator === null || !$this->validator->passes()) {
            throw new \Exception("Data has not been validated or validation failed.");
        }
        return $this->validator->getValidatedData();
    }

    /**
     * Get validation errors.
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->validator ? $this->validator->getErrors() : [];
    }

    /**
     * Get request method.
     *
     * @return string
     */
    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get request URI except request params.
     *
     * @return string
     */
    public function getRequestUri()
    {
        $uri = $_SERVER['REQUEST_URI'];

        // Remove query parameters
        $uri = strtok($uri, '?');

        // Normalize root '/' or trailing slashes
        return $uri === '/' ? '/' : rtrim($uri, '/');
    }
}
