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
$router->get('/admin/users', [UserController::class, 'index'])->only(['auth']);
$router->get('/admin/users/create', [UserController::class, 'create'])->only(['auth']);
$router->post('/admin/users', [UserController::class, 'store'])->only(['auth']);
$router->get('/admin/users/{id}/show', [UserController::class, 'show'])->only(['auth']);
$router->get('/admin/users/{id}/edit', [UserController::class, 'edit'])->only(['auth']);
$router->put('/admin/users/{id}/update', [UserController::class, 'update'])->only(['auth']);
$router->delete('/admin/users/{id}/delete', [UserController::class, 'delete'])->only(['auth']);
$router->put('/admin/users/{id}/change-status', [UserController::class, 'changeStatus'])->only(['auth']);
// User profile routes
$router->get('/admin/user-profile', [UserController::class, 'userProfile'])->only(['auth']);
$router->put('/admin/change-profile-picture', [UserController::class, 'changeProfilePicture'])->only(['auth']);
$router->get('/admin/edit-profile', [UserController::class, 'editProfile'])->only(['auth']);
$router->put('/admin/update-profile', [UserController::class, 'updateProfile'])->only(['auth']);
$router->get('/admin/change-password', [UserController::class, 'changePassword'])->only(['auth']);
$router->put('/admin/change-password', [UserController::class, 'saveChangedPassword'])->only(['auth']);

// authentication routes
$router->get('/login', [AuthenticationController::class, 'index'])->only(['guest']);
$router->post('/login', [AuthenticationController::class, 'login'])->only(['guest']);
$router->get('/register', [AuthenticationController::class, 'registerPage'])->only(['guest']);
$router->post('/register', [AuthenticationController::class, 'register'])->only(['guest']);
$router->post('/logout', [AuthenticationController::class, 'logout'])->only(['auth']);
