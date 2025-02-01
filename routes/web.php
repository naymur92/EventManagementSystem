<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\HostApiController;
use App\Http\Controllers\Api\TicketApiController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;

// Define routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/events', [HomeController::class, 'eventPage']);
$router->get('/events/{event_id}/view-details', [HomeController::class, 'eventDetailsPage']);

$router->get('/events/{event_id}/get-ticket', [TicketController::class, 'eventRegistrationPage']);
$router->get('/my-tickets', [TicketController::class, 'myTickets'])->only(['auth']);
$router->get('/tickets/{unique_id}/view-ticket', [TicketController::class, 'viewTicket']);
$router->get('/tickets/find-ticket', [TicketController::class, 'findTicket']);

############################################# Admin Routes #############################################
// dashboard routes
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

// events routes
$router->get('/admin/events', [EventController::class, 'index'])->only(['auth', 'super&host']);
$router->get('/admin/events/create', [EventController::class, 'create'])->only(['auth', 'hostuser']);
$router->post('/admin/events', [EventController::class, 'store'])->only(['auth', 'hostuser']);
$router->get('/admin/events/{id}/show', [EventController::class, 'show'])->only(['auth', 'super&host']);
$router->get('/admin/events/{id}/edit', [EventController::class, 'edit'])->only(['auth', 'hostuser']);
$router->put('/admin/events/{id}/update', [EventController::class, 'update'])->only(['auth', 'hostuser']);
$router->delete('/admin/events/{id}/delete', [EventController::class, 'delete'])->only(['auth', 'super&host']);
$router->put('/admin/events/{id}/change-status', [EventController::class, 'changeStatus'])->only(['auth', 'super&host']);
$router->get('/admin/events/{id}/attendee-list', [EventController::class, 'attendeeList'])->only(['auth', 'super&host']);
$router->get('/admin/events/{id}/attendee-list', [EventController::class, 'attendeeList'])->only(['auth', 'super&host']);

// tickets
$router->get('/admin/tickets/{unique_id}/view-ticket', [EventController::class, 'viewTicket'])->only(['auth', 'super&host']);


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

// Apis
$router->post('/api/get-event-schedules', [EventApiController::class, 'getEventSchedules'])->only(['cors']);
$router->post('/api/get-events', [EventApiController::class, 'getEvents'])->only(['cors']);
$router->post('/api/get-event-detail', [EventApiController::class, 'getEventDetails'])->only(['cors']);
$router->post('/api/event-registration', [EventApiController::class, 'eventRegistration'])->only(['cors']);

$router->post('/api/cancel-tickets', [TicketApiController::class, 'cancelTicket'])->only(['cors']);
$router->post('/api/find-tickets', [TicketApiController::class, 'findTicket'])->only(['cors']);

$router->post('/api/get-host-users', [HostApiController::class, 'getHostUsers'])->only(['cors']);
