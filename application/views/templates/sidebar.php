<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard'); ?>">
    <div class="sidebar-brand-icon">
      <i class="fas fa-tint"></i> <!-- Air / PDAM related icon -->
    </div>
    <div class="sidebar-brand-text mx-3">EBILL PDAM</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('dashboard'); ?>">
      <i class="fas fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link pt-0" href="<?= base_url('dashboard/dashboard2'); ?>">
      <i class="fas fa-tachometer-alt"></i>
      <span>Dashboard 2</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">Master Data</div>

  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('pelanggan'); ?>">
      <i class="fas fa-users"></i>
      <span>Pelanggan</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">Upload Data</div>

  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('tagihanbaru'); ?>">
      <i class="fas fa-file-upload"></i>
      <span>Tagihan</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link pt-0" href="<?= base_url('catatmeter'); ?>">
      <i class="fas fa-chart-line"></i>
      <span>Catat Meter</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link pt-0" href="<?= base_url('subsidi'); ?>">
      <i class="fas fa-hand-holding-usd"></i>
      <span>Subsidi</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link pt-0" href="<?= base_url('denda'); ?>">
      <i class="fas fa-exclamation-circle"></i>
      <span>Denda</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">Tagihan</div>

  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('tagihan'); ?>">
      <i class="fas fa-file-invoice-dollar"></i>
      <span>Tagihan Pelanggan</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link pt-0" href="<?= base_url('tagihan/laporan_pelunasan'); ?>">
      <i class="fas fa-search"></i>
      <span>Cari Pelanggan</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link pt-0" href="<?= base_url('tagihan/cek_pelunasan'); ?>">
      <i class="fas fa-check-circle"></i>
      <span>Laporan Pelunasan</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">Lainnya</div>

  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('tagihan/laporan_setoran'); ?>">
      <i class="fas fa-history"></i>
      <span>Riwayat Setoran</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link pt-0" href="<?= base_url('pelanggan/putus_berlangganan'); ?>">
      <i class="fas fa-user-slash"></i>
      <span>Pelanggan Putus</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">Setting</div>

  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('profilecompany/'); ?>">
      <i class="fas fa-building"></i>
      <span>Profile Perusahaan</span></a>
  </li>

  <?php if (is_admin()) : ?>

  <li class="nav-item">
    <a class="nav-link pt-0" href="<?= base_url('admin'); ?>">
      <i class="fas fa-user-cog"></i>
      <span>User Management</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link pt-0" href="<?= base_url('menu'); ?>">
      <i class="fas fa-th-list"></i>
      <span>Menu Management</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link pt-0" href="<?= base_url('cabang'); ?>">
      <i class="fas fa-code-branch"></i>
      <span>Cabang</span></a>
  </li>

  <?php endif; ?>

  <li class="nav-item">
    <a class="nav-link pt-0" href="<?= base_url('log'); ?>">
      <i class="fas fa-clipboard-list"></i>
      <span>Riwayat Aktivitas</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
      <i class="fas fa-sign-out-alt"></i>
      <span>Logout</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->
