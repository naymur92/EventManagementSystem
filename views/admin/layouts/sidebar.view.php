<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= route('/admin') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <!-- <i class="fas fa-laugh-wink"></i> -->
        </div>
        <div class="sidebar-brand-text mx-3"><?= getEnvData('APP_NAME') ?></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item <?= urlInList(['/admin']) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= route('/admin') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading mb-2">
        Event Management
    </div>

    <li class="nav-item <?= urlInList(['product-units']) ? 'active' : '' ?>">
        <a class="nav-link" href="#">
            <i class="fa-solid fa-scale-unbalanced-flip"></i>
            <span>Events</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading mb-2">
        Site Configuration
    </div>

    <li class="nav-item <?= urlInList(['/admin/users', '/admin/users/create']) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= route('/admin/users') ?>">
            <i class="fa-solid fa-users-gear"></i>
            <span>Auth Users</span></a>
    </li>

    <li class="nav-item <?= urlInList(['company-information']) ? 'active' : '' ?>">
        <a class="nav-link" href="#">
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