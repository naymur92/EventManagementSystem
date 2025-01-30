<?php

namespace App\Http\Middleware;

class Middleware
{
    public const MAP = [
        'guest' => GuestMiddleware::class,
        'auth' => AuthMiddleware::class,
        'superuser' => SuperUserMiddleware::class,
        'hostuser' => HostUserMiddleware::class,
        'super&host' => SuperAndHostUserMiddleware::class,
        'cors' => CorsMiddleware::class,
    ];

    public static function resolve(array $keys): void
    {
        foreach ($keys as $key) {
            if (!isset(self::MAP[$key])) {
                throw new \Exception("Middleware key '$key' not found in middleware map.");
            }

            $middlewareClass = self::MAP[$key];
            $middlewareInstance = new $middlewareClass();

            if (!method_exists($middlewareInstance, 'handle')) {
                throw new \Exception("Middleware $middlewareClass must have a handle() method.");
            }

            // Execute the middleware's handle method
            $middlewareInstance->handle();
        }
    }
}
