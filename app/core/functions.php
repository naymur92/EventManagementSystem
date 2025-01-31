<?php

use App\Core\Auth;
use App\Core\Config;
use App\Core\CSRF;
use App\Core\Env;
use App\Core\Router;
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
    return Router::filterCurrentUri($_SERVER['REQUEST_URI']) === $value;
}


/**
 * Check the current url
 *
 * @param array $routeList
 * @return boolean
 */
function urlInList(array $routeList): bool
{
    $currentUri = Router::filterCurrentUri($_SERVER['REQUEST_URI']);

    foreach ($routeList as $route) {
        $pattern = "#^" . preg_replace('/\{[^\/]+\}/', '([^/]+)', $route) . "$#";
        if (preg_match($pattern, $currentUri, $matches)) {
            return true;
        }
    }
    return false;
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
    // Get the script name (e.g., /folderName/public/index.php)
    $scriptName = $_SERVER['SCRIPT_NAME'];

    // Remove /index.php from the script name to get the base path
    $basePath = str_replace('/index.php', '', $scriptName);

    // Get the protocol (http or https)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';

    // Get the host (e.g., localhost or domain.com)
    $host = $_SERVER['HTTP_HOST'];

    // Combine protocol, host, and base path to form the base URL
    return $protocol . $host . $basePath;
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
    header('Location: ' . route($route));
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


/**
 * Get data from .env file
 *
 * @param string $key
 * @param string $default
 * @return string
 */
function getEnvData(string $key, string $default = ''): string
{
    return Env::get($key, $default);
}

/**
 * Get data from config files
 *
 * @param string $path
 * @return void
 */
function getConfig(string $path)
{
    return Config::get($path);
}


/**
 * Get flash data from session
 *
 * @return array
 */
function getFlashData(): array
{
    return Session::getFlash();
}


/**
 * Get popup data from session
 *
 * @return array
 */
function getPopupData(): array
{
    return Session::getPopup();
}


/**
 * Generate full route with base url
 *
 * @param string $path
 * @return string
 */
function route(string $path): string
{
    // Get the base URL
    $baseUrl = getBaseUrl();

    // Ensure the path starts with a slash
    if ($path == '' || $path[0] !== '/') {
        $path = '/' . $path;
    }

    // Return the full URL
    return $baseUrl . $path;
}


/**
 * Set unique id in form open and check it to controller to prevent multiple submit
 *
 * @param $operationType
 */
function setUnsetUniqueId($operationType = null)
{
    if ($operationType == 'get') {
        $session_data = $_SESSION['unique_id'];

        $_SESSION['unique_id'] = null;

        return $session_data;
    } else {
        $uniqid = substr(bin2hex(openssl_random_pseudo_bytes(15)), 0, 30);
        $_SESSION['unique_id'] = $uniqid;
    }
}
