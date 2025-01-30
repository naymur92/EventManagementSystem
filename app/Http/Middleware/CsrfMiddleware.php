<?php

namespace App\Http\Middleware;

use App\Core\CSRF;

class CsrfMiddleware
{
    protected array $exceptCsrfRoutes = [];

    public function __construct(array $exceptCsrfRoutes = [])
    {
        $this->exceptCsrfRoutes = $exceptCsrfRoutes;
    }

    public function shouldSkip($method, $uri): bool
    {
        foreach ($this->exceptCsrfRoutes as $exceptRoute) {
            $pattern = "#^" . preg_replace('/\{[^\/]+\}/', '([^/]+)', $exceptRoute) . "$#";
            if (preg_match($pattern, $uri)) {
                return true;
            }
        }

        return false;
    }

    public function verify($method, $uri, $request)
    {
        if ($method === 'GET' || $this->shouldSkip($method, $uri)) {
            return true; // Skip CSRF check for GET requests or defined routes
        }

        // Check token from request body or headers
        $token = $request->input('_csrf_token')
            ?? $request->header('X-CSRF-TOKEN')
            ?? $request->header('X-Requested-With')
            ?? '';

        if (!Csrf::verifyToken($token)) {
            throw new \Exception("Invalid CSRF token", 403);
        }

        return true;
    }
}
