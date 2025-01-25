<?php

use App\Core\Auth;
use App\Core\Config;
use App\Core\CSRF;
use App\Core\Env;
use App\Core\Session;
use App\Core\View;

/**
 * view helper file to load view from controller
 *
 * @param string $filename
 * @param array $params
 * @return void
 */
function view(string $filename, array $params): void
{
    $viewObj = new View();
    $viewObj->view($filename, $params);
}

/**
 * Print data and die
 *
 * @param mixed $data
 * @return void
 */
function dd(mixed $data): void
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";

    die;
}


/**
 * Check the current url
 *
 * @param string $value
 * @return boolean
 */
function urlIs(string $value): bool
{
    return $_SERVER['REQUEST_URI'] === $value;
}


/**
 * Get absolute path of a file
 *
 * @param string $path
 * @return string
 */
function basePath(string $path): string
{
    return BASE_PATH . $path;
}


/**
 * Get base URL
 *
 * @return string
 */
function getBaseUrl(): string
{
    return Env::get('APP_URL', '/');
}


/**
 * Generate URL from route
 *
 * @param string $route
 * @return string
 */
function generateUrl(string $route): string
{
    return getBaseUrl() . $route;
}


/**
 * Get old form data from session
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function old(string $key, mixed $default = ''): mixed
{
    return $_SESSION['old'][$key] ?? $default;
}

/**
 * Check validation error exists or not
 *
 * @param string $key
 * @return boolean
 */
function hasError(string $key): bool
{
    return isset($_SESSION['error'][$key]);
}

/**
 * Get validation errors from session
 *
 * @param string $key
 * @return array
 */
function errors(string $key): array
{
    return $_SESSION['error'][$key] ?? array();
}

/**
 * Redirect to a page
 *
 * @param string $route
 * @return void
 */
function redirect(string $route)
{
    header('Location: ' . $route);
    exit;
}


/**
 * Get authenticated user
 *
 * @return object|null
 */
function authUser(): object|null
{
    return Auth::user();
}


/**
 * Get csrf value
 *
 * @return string
 */
function csrf(): string
{
    return htmlspecialchars(CSRF::generateToken());
}


/**
 * Get csrf field for form
 *
 * @return string
 */
function csrfField(): string
{
    return '<input type="hidden" name="_csrf_token" value="' . csrf() . '">';
}


function getEnvData(string $key, string $default = ''): string
{
    return Env::get($key, $default);
}

function getConfig(string $path)
{
    return Config::get($path);
}


function getFlashData(): array
{
    $data = $_SESSION['_flash'] ?? array();
    Session::unflash();

    return $data;
}
