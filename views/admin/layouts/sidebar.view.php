<?php
// $c_con_array = explode('.', Route::currentRouteName());
$c_con_array = '';
global $current_controller;
// $current_controller = $c_con_array[0];
// set collapsed class
if (!function_exists('isCollapsed')) {
    function isCollapsed(array $controllerNameArray)
    {
        global $current_controller;
        if (!in_array($current_controller, $controllerNameArray)) {
            echo 'collapsed';
        }
    }
}
// set active class in li tag
if (!function_exists('isActiveLI')) {
    function isActiveLI(array $controllerName)
    {
        global $current_controller;
        if (in_array($current_controller, $controllerName)) {
            echo 'active';
        }
    }
}

// set show class in a tag
if (!function_exists('isShow')) {
    function isShow($controllerName)
    {
        global $current_controller;
        if ($current_controller == $controllerName) {
            echo 'show';
        }
    }
}

// set active class
// if (!function_exists('isActive')) {
//     function isActive($routeName)
//     {
//         if (Route::currentRouteName() == $routeName) {
//             echo 'active';
//         }
//     }
// }

?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
        <div class="sidebar-brand-icon rotate-n-15">
            <!-- <i class="fas fa-laugh-wink"></i> -->
        </div>
        <div class="sidebar-brand-text mx-3"><?= getEnvData('APP_NAME') ?></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ isActiveLI(['dashboard']) }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading mb-2">
        Event Management
    </div>

    <li class="nav-item {{ isActiveLI(['product-units']) }}">
        <a class="nav-link" href="{{ route('product-units.index') }}">
            <i class="fa-solid fa-scale-unbalanced-flip"></i>
            <span>Events</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading mb-2">
        Site Configuration
    </div>

    <li class="nav-item {{ isActiveLI(['users']) }}">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fa-solid fa-users-gear"></i>
            <span>Auth Users</span></a>
    </li>

    <li class="nav-item {{ isActiveLI(['company-information']) }}">
        <a class="nav-link" href="{{ route('company-information.index') }}">
            <i class="fa-solid fa-info"></i>
            <span>Company Information</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>