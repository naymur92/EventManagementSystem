<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;

// Define routes
$router->get('/', [HomeController::class, 'index']);

// admin routes
$router->get('/admin', [DashboardController::class, 'index'])->only(['auth']);
// users routes
$router->get('/admin/users', [UserController::class, 'index'])->only(['auth', 'superuser']);
$router->get('/admin/users/create', [UserController::class, 'create'])->only(['auth', 'superuser']);
$router->post('/admin/users', [UserController::class, 'store'])->only(['auth', 'superuser']);
$router->get('/admin/users/{id}/show', [UserController::class, 'show'])->only(['auth', 'superuser']);
$router->get('/admin/users/{id}/edit', [UserController::class, 'edit'])->only(['auth', 'superuser']);
$router->put('/admin/users/{id}/update', [UserController::class, 'update'])->only(['auth', 'superuser']);
$router->delete('/admin/users/{id}/delete', [UserController::class, 'delete'])->only(['auth', 'superuser']);
$router->put('/admin/users/{id}/change-status', [UserController::class, 'changeStatus'])->only(['auth', 'superuser']);

// User profile routes
$router->get('/user-profile', [UserController::class, 'userProfile'])->only(['auth']);
$router->put('/change-profile-picture', [UserController::class, 'changeProfilePicture'])->only(['auth']);
$router->get('/edit-profile', [UserController::class, 'editProfile'])->only(['auth']);
$router->put('/update-profile', [UserController::class, 'updateProfile'])->only(['auth']);
$router->get('/change-password', [UserController::class, 'changePassword'])->only(['auth']);
$router->put('/change-password', [UserController::class, 'saveChangedPassword'])->only(['auth']);

// authentication routes
$router->get('/login', [AuthenticationController::class, 'index'])->only(['guest']);
$router->post('/login', [AuthenticationController::class, 'login'])->only(['guest']);
$router->get('/register', [AuthenticationController::class, 'registerPage'])->only(['guest']);
$router->post('/register', [AuthenticationController::class, 'register'])->only(['guest']);
$router->post('/logout', [AuthenticationController::class, 'logout'])->only(['auth']);
