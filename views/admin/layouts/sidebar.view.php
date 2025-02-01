<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= route('/admin') ?>">
        <div class="sidebar-brand-icon">
            <!-- <i class="fas fa-laugh-wink"></i> -->
            <img src="<?= getBaseUrl() ?>/assets/img/logo/fav-logo1.png" alt="">
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



    <?php if (authUser()->type == 1 || authUser()->type == 2): ?>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading mb-2">
            Event Management
        </div>

        <li class="nav-item <?= urlInList(['/admin/events', '/admin/events/create', '/admin/events/{id}/show', '/admin/events/{id}/edit', '/admin/events/{id}/attendee-list']) ? 'active' : '' ?>">
            <a class="nav-link" href="<?= route('/admin/events') ?>">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Events</span></a>
        </li>
    <?php endif; ?>


    <?php if (authUser()->type == 1 || authUser()->type == 2): ?>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading mb-2">
            Reports
        </div>

        <li class="nav-item <?= urlInList(['/admin/reports/event-report']) ? 'active' : '' ?>">
            <a class="nav-link" href="<?= route('/admin/reports/event-report') ?>">
                <i class="fa-solid fa-chart-line"></i>
                <span>Event Report</span></a>
        </li>
    <?php endif; ?>


    <?php if (authUser()->type == 1): ?>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading mb-2">
            Portal Management
        </div>

        <li class="nav-item <?= urlInList(['/admin/users', '/admin/users/create', '/admin/users/{id}/show', '/admin/users/{id}/edit']) ? 'active' : '' ?>">
            <a class="nav-link" href="<?= route('/admin/users') ?>">
                <i class="fa-solid fa-users-gear"></i>
                <span>Auth Users</span></a>
        </li>
    <?php endif; ?>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>