<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>" class="brand-link">
        <img src="/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Fear Library</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url() ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Ferdinand</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-header text-danger">Master Data</li>
                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Buku
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('buku') ?>" class="nav-link">
                                <i class="fas fa-book-open nav-icon"></i>
                                <p>Daftar Buku</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('kategori') ?>" class="nav-link">
                                <i class="fas fa-bookmark nav-icon"></i>
                                <p>Kategori Buku</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('petugas') ?>" class="nav-link">
                        <i class="fas fa-user-shield nav-icon"></i>
                        <p>Petugas</p>
                    </a>
                </li>
                <li class="nav-item user-panel">
                    <a href="<?= base_url('anggota') ?>" class="nav-link">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Member</p>
                    </a>
                </li>

                <li class="nav-header text-primary">Management Data</li>
                <li class="nav-item">
                    <a href="<?= base_url('peminjaman') ?>" class="nav-link">
                        <i class="fas fa-cart-arrow-down nav-icon"></i>
                        <p>Peminjaman</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('pengembalian') ?>" class="nav-link">
                        <i class="fas fa-exchange-alt nav-icon"></i>
                        <p>Pengembalian</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>