<?php

namespace App\Core;

use App\Http\Middleware\CsrfMiddleware;
use App\Http\Middleware\Middleware;

class Router
{
    protected array $routes = [];
    protected array $supportedMethods = ['GET', 'POST', 'PUT', 'DELETE'];
    protected array $middlewares = [];

    protected ?array $currentRoute = null;


    /**
     * Register a route for any HTTP method
     *
     * @param string $method
     * @param string $uri
     * @param callable|array $callback
     * @return self
     */
    public function addRoute(string $method, string $uri, callable|array $callback): self
    {
        $method = strtoupper($method);
        if (!in_array($method, $this->supportedMethods)) {
            throw new \Exception("HTTP method $method not supported.");
        }

        $this->currentRoute = [
            'method' => $method,
            'uri' => $uri,
        ];

        $this->routes[$method][$uri] = array(
            'callback' => $callback,
            'middleware' => [],
        );

        return $this;
    }

    /**
     * Add middleware to route
     *
     * @param array $keys
     * @return self
     */
    public function only(array $keys): self
    {
        if ($this->currentRoute === null) {
            throw new \Exception("Cannot set middleware: No route is being defined.");
        }

        $method = $this->currentRoute['method'];
        $uri = $this->currentRoute['uri'];

        // Add middleware to the current route
        $this->routes[$method][$uri]['middleware'] = $keys;

        // Reset the current route context to avoid conflicts
        $this->currentRoute = null;

        return $this;
    }

    /**
     * Register a GET route
     *
     * @param string $uri
     * @param callable|array $callback
     * @return self
     */
    public function get(string $uri, callable|array $callback): self
    {
        return $this->addRoute('GET', $uri, $callback);
    }

    /**
     * Register a POST route
     *
     * @param string $uri
     * @param callable|array $callback
     * @return self
     */
    public function post(string $uri, callable|array $callback): self
    {
        return $this->addRoute('POST', $uri, $callback);
    }

    /**
     * Register a PUT route
     *
     * @param string $uri
     * @param callable|array $callback
     * @return self
     */
    public function put(string $uri, callable|array $callback): self
    {
        return $this->addRoute('PUT', $uri, $callback);
    }

    /**
     * Register a DELETE route
     *
     * @param string $uri
     * @param callable|array $callback
     * @return self
     */
    public function delete(string $uri, callable|array $callback): self
    {
        return $this->addRoute('DELETE', $uri, $callback);
    }

    /**
     * Update request method for PUT and DELETE
     *
     * @return void
     */
    public function updateRequestMethod()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
            if (in_array($method, ['PUT', 'DELETE'])) {
                $_SERVER['REQUEST_METHOD'] = $method;
            }
        }
    }

    /**
     * Resolve the current route and execute its callback
     *
     * @param Request $request
     * @return void
     */
    public function resolve(Request $request)
    {
        // update method
        $this->updateRequestMethod();

        $method = $request->getRequestMethod();
        $uri = $request->getRequestUri();

        // Normalize the URI by removing the base path
        $uri = self::filterCurrentUri($uri);

        if (!isset($this->routes[$method])) {
            throw new \Exception("Method $method not allowed", 405);
        }

        foreach ($this->routes[$method] as $route => $item) {
            $callback = $item['callback'];
            $middleware = $item['middleware'];

            // Static routes
            if ($route === $uri) {
                $this->checkCsrf($method, $uri, $request);

                // call middleware
                if (!empty($middleware)) {
                    Middleware::resolve($middleware);
                }

                return $this->executeCallback($callback, [$request]);
            }

            // Dynamic routes
            $pattern = $this->convertToRegex($route);
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                $this->checkCsrf($method, $uri, $request);

                // call middleware
                if (!empty($middleware)) {
                    Middleware::resolve($middleware);
                }

                return $this->executeCallback($callback, array_merge([$request], $matches));
            }
        }

        throw new \Exception("Route not found", 404);
    }


    /**
     * Convert a route with placeholders
     *
     * @param string $route
     * @return string
     */
    private function convertToRegex(string $route): string
    {
        $pattern = preg_replace('/\{[^\/]+\}/', '([^/]+)', $route);
        return "#^" . $pattern . "$#";
    }

    /**
     * Execute a callback or controller action
     *
     * @param callable|array $callback
     * @param array $routeParams
     * @return mixed
     */
    private function executeCallback(callable|array $callback, array $routeParams = [])
    {
        if (is_array($callback)) {
            [$controllerClass, $method] = $callback;

            // Instantiate the controller
            $controller = new $controllerClass();

            // Check if the method expects a Request object
            $reflection = new \ReflectionMethod($controller, $method);

            $requestParamFound = false;
            foreach ($reflection->getParameters() as $param) {
                $paramType = $param->getType();

                if ($paramType && $paramType->getName() === Request::class) {
                    $requestParamFound = true;
                    break;
                }
            }

            // remove the request class from $routeParams if method not contains Request class
            if (!$requestParamFound) {
                for ($i = 0; $i < count($routeParams); $i++) {
                    if ($routeParams[$i] instanceof Request) {
                        unset($routeParams[$i]);
                    }
                }
            }

            // Call the controller method with resolved arguments
            return call_user_func_array([$controller, $method], $routeParams);
        }

        // For callable functions
        return call_user_func_array($callback, $routeParams);
    }

    /**
     * Check csrf value existing in $request
     *
     * @param string $method
     * @param string $uri
     * @param Request $request
     * @return void
     */
    private function checkCsrf(string $method, string $uri, Request $request)
    {
        $csrfExceptions = Config::get('config.csrf-exceptions');

        $csrfMiddleware = new CsrfMiddleware($csrfExceptions ?? []);

        $csrfMiddleware->verify($method, $uri, $request);
    }

    /**
     * Normalize the URI by removing the base path
     *
     * @param string $uri
     * @return string
     */
    public static function filterCurrentUri(string $uri): string
    {
        $basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
            if ($uri == '') $uri = '/';
        }

        return $uri;
    }
}
