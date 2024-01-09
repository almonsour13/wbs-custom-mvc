<!-- Sidebar -->
<?php
   $url = isset($_GET['url']) ? $_GET['url'] : '/';
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
        <div class="sidebar-brand-icon ">
            WBS
        </div>
        <div class="sidebar-brand-text mx-3">Admin<sup></sup></div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item" style="<?php echo ($url === 'consumer') ? 'border-right:10px white solid;' : ''; ?>">
        <a class="nav-link" href="consumer">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Consumer</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->