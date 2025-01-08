<nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow mr-0 ml-0">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle">
                        <i class="fa fa-bars"></i>
                    </button>
                
    <?php if( in_groups('nasabah')) : ?>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item d-none d-sm-block">
                <a class="nav-link text-gray-600 active" href="<?= base_url('/');?>">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-gray-600" href="<?= base_url('about');?>">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-gray-600" href="<?= base_url('help');?>">Help</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-gray-600" href="<?= base_url('contact');?>">Contact</a>
            </li>
        </ul>
    </div>
    <?php endif; ?>
    <!-- Di navbar -->
        <a class="nav-link position-relative" href="<?= base_url('notifikasi') ?>">
            <i class="fas fa-bell"></i>
            <?php 
            $notifModel = new \App\Models\NotifikasiModel();
            $unreadCount = $notifModel->where('user_id', user()->id)
                                    ->where('is_read', 0)
                                    ->countAllResults();
            ?>
            <?php if ($unreadCount > 0) : ?>
                <span id="notif-badge" class="position-absolute start-100 translate-middle badge rounded-pill bg-danger">
                    <?= $unreadCount ?>
                </span>
            <?php endif; ?>
        </a>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                <span class="mr-2 <?php if( in_groups('nasabah')) : ?> d-none <?php endif; ?>  d-lg-inline text-dark small"><?= user()->username; ?></span>
                <img class="img-profile rounded-circle" src="<?= base_url();?>/Assets/img/<?= user()->user_image;?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url('profile');?>">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    My Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url('reset-password');?>">
                    <i class="fas fa-user-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                    Reset Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>