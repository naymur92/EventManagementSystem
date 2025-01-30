<?php

namespace App\Http\Middleware;

class CorsMiddleware
{
    private $allowedOrigins = ['http://localhost:8000'];

    public function handle()
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        // Allow only specific origins
        if (!in_array($origin, $this->allowedOrigins)) {
            header('HTTP/1.1 403 Forbidden');
            exit('Forbidden: Cross-origin requests are not allowed.');
        }

        // Set CORS headers
        header('Access-Control-Allow-Origin: ' . $origin);
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }
}
