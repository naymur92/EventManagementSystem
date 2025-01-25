<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;

// Define routes
$router->get('/', [HomeController::class, 'index']);

$router->get('/admin', [DashboardController::class, 'index'])->only(['auth']);

$router->get('/login', [AuthenticationController::class, 'index'])->only(['guest']);
$router->post('/login', [AuthenticationController::class, 'login'])->only(['guest']);
$router->get('/register', [AuthenticationController::class, 'registerPage'])->only(['guest']);
$router->post('/register', [AuthenticationController::class, 'register'])->only(['guest']);
$router->post('/logout', [AuthenticationController::class, 'logout'])->only(['auth']);
