<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= BASE_URL ?>index.php?page=dashboard">

        <div class="sidebar-brand-text mx-3">TrustedCargo</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?= BASE_URL ?>index.php?page=dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Settings
    </div>


    <?php require_once __DIR__ . '/sidebar/sidebarProfile.php'; ?>
    <?php require_once __DIR__ . '/sidebar/sidebarUser.php'; ?>
    <?php require_once __DIR__ . '/sidebar/sidebarMailing.php'; ?>
    <?php require_once __DIR__ . '/sidebar/sidebarContact.php'; ?>
    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>