<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

use App\Core\Env;
use App\Core\Request;
use App\Core\Router;

const BASE_PATH     = __DIR__ . '/../';
const UPLOAD_DIR    = __DIR__ . '/uploads/';

require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'app/core/functions.php';
require BASE_PATH . 'bootstrap.php';

// Load environment configuration
Env::loadEnv();

############################### Routing part starts ###############################
$router = new Router();
$request = new Request();

// load route files
require BASE_PATH . 'routes/web.php';

try {
    echo $router->resolve($request);
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo $e->getMessage();
}
############################### Routing part ends ###############################
