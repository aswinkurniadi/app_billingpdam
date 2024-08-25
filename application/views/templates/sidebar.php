<!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard'); ?>">
        <div class="sidebar-brand-icon">
          <i class="fas fa-fw fa-user"></i>
        </div>
        <div class="sidebar-brand-text mx-3">EBILL PDAM</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('dashboard'); ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Data Pelanggan
      </div>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('pelanggan'); ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pelanggan</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('pelanggan/putus_berlangganan'); ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pelanggan Putus</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('paket'); ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Paket</span></a>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Pelunasan Tagihan
      </div>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('tagihan/cari_pelanggan'); ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Cari Pelanggan</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('tagihan/laporan_pelunasan'); ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Laporan Pelunasan</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Tagihan Pelanggan
      </div>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('tagihan'); ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Tagihan Pelanggan</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('tagihan/laporan_belum_lunas'); ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Tagihan Belum Lunas</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('tagihan/cek_pelunasan'); ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Cek Pelunasan</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('tagihan/laporan_setoran'); ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Riwayat Setoran</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">
      
      <!-- Heading -->
      <div class="sidebar-heading">
        Setting
      </div>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('impor'); ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Impor Tagihan *</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('profilecompany/'); ?>">
          <i class="fas fa-fw fa-building"></i>
          <span>Profile Perusahaan</span></a>
      </li>
      
      <?php if (is_admin()) : ?>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('admin'); ?>">
          <i class="fas fa-fw fa-user-plus"></i>
          <span>User Management</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('menu'); ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Menu Management</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('cabang'); ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Cabang</span></a>
      </li>

      <?php endif; ?>


      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('log'); ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Riwayat Aktivitas</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar