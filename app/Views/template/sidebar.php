<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled shadow" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="mt-3 sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('/');?>">
                    <img src="<?= base_url();?>/Assets/img/logo_point.svg" style="width:50px;" alt="eco">
                <div class="sidebar-brand-text mx-1">Eco Market</div>
            </a>

            <?php if( in_groups('admin')) : ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Admin Managemen
            </div>

            <!-- Nav Item - Edit User -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/admin');?>">
                <i class="fa fa-home"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Nav Item - User List -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/user-management') ?>">
                <i class="fa fa-users"></i>
                    <span>Aktivasi User</span></a>
            </li>
            <!-- Nav Item - User List -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/laporan') ?>">
                <i class="fas fa-file-alt"></i>
                    <span>Laporan Transaksi</span></a>
            </li>
                        <!-- Divider -->
                        <hr class="sidebar-divider">
            
            <!-- Heading -->
            <div class="sidebar-heading">
                Rekap Transaksi
            </div>
            <!-- Nav Item - My Profile -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/transaksi_sampah');?>">
                <i class="fas fa-trash-alt"></i>
                    <span>Transaksi Sampah</span></a>
            </li>
            <!-- Nav Item - My Profile -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/transaksi_produk');?>">
                <i class="fas fa-shopping-cart"></i>
                    <span>Transaksi Produk</span></a>
            </li>
            <!-- Nav Item - My Profile -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/transaksi_penarikan');?>">
                <i class="fas fa-money-bill-wave"></i>
                    <span>Transaksi E-Wallet</span></a>
            </li>
            <!-- Garis -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Page Menu
            </div>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/sampah')?>">
                <i class="fas fa-recycle"></i>
                    <span>Sampah Terkumpul</span></a>
            </li>
            <?php endif; ?>
            <!-- admin end -->

            <!-- nasabah -->
            <?php if( in_groups('nasabah')) : ?>
                <br>
            <!-- Garis -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Page Menu Nasabah
            </div>

            <!-- Nav Item - My Profile -->
             
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('jualSampah');?>">
                <i class="fa fa-trash"></i>
                    <span>Jual Sampah</span></a>
            </li>

            <!-- Nav Item - Edit User -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('tukarProduk');?>">
                <i class="fas fa-warehouse"></i>
                    <span>Tukar Produk</span></a>
            </li>
            <!-- Nav Item - Edit User -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('tentangKita');?>">
                <i class="fas fa-tree"></i> 
                    <span>Tentang Eco Market</span></a>
            </li>
            <!-- Nav Item - Edit User -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('user/riwayatPenarikan');?>">
                <i class="fas fa-history"></i>
                    <span>Riwayat Penarikan</span></a>
            </li>
            <!-- Nav Item - Edit User -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('user/riwayat_point');?>">
                <i class="fas fa-coins"></i>
                    <span>Riwayat Point</span></a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('contact');?>">
                <i class="fa fa-phone"></i>
                    <span>Bantuan</span></a>
            </li>
            <?php endif; ?>
            <!-- nasabah end-->

            <!-- selller -->
            <?php if( in_groups('seller')) : ?>
                <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Seller
            </div>

            <!-- Nav Item - Edit User -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/seller');?>">
                <i class="fa fa-home"></i>
                    <span>Dashboard</span></a>
            </li>
            <!-- Nav Item - Edit User -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('seller/riwayatPenarikan');?>">
                <i class="fas fa-history"></i>
                    <span>Riwayat Penarikan</span></a>
            </li>
            <!-- Nav Item - Edit User -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('seller/riwayat_saldo');?>">
                <i class="fas fa-coins"></i>
                    <span>Riwayat Point</span></a>
            </li>
            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('contact');?>">
                <i class="fa fa-phone"></i>
                    <span>Bantuan</span></a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('reset-password');?>">
                <i class="fa fa-user-edit"></i>
                    <span>Reset Password</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal"">
                <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle">
            </div>

        </ul>