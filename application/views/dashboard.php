<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title;  ?></h1>

    <form action="" method="post" class="form-inline">
      <div class="form-group mb-2 mr-2">
        <select class="form-control" name="cabang" id="cabang" required="">
            <option value="">Pilih Kantor</option>
            <?php foreach($cabang as $cab) : ?>
              <option value="<?= $cab['id_cabang']; ?>" <?= ($id_cabang == $cab['id_cabang']) ? "selected" : null; ?>><?= $cab['nama']; ?></option>
            <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-save"></i></button>
    </form>
  </div>
  
  <div class="row">
  	<!-- jumlah berita-->

      <!-- jumlah pengguna -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Tagihan Bulan ini</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlahuser; ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-fw fa-user-plus fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- jumlah pengguna -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Sudah Terbayar</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlahuser; ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-fw fa-user-plus fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- jumlah pengguna -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Sisa Tagihan</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlahuser; ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-fw fa-user-plus fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- jumlah pengguna -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Pelanggan</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlahuser; ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-fw fa-user-plus fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      

  </div>





  <div class="row">
    
      <!-- Area Chart -->
      <div class="col-xl-8 col-lg-7">
          <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header bg-primary py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-white">Total Terlunasi vs. Belum Lunas Tahun <?= date('Y'); ?></h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                  <div class="chart-area">
                      <div class="chartjs-size-monitor">
                          <div class="chartjs-size-monitor-expand">
                              <div class=""></div>
                          </div>
                          <div class="chartjs-size-monitor-shrink">
                              <div class=""></div>
                          </div>
                      </div>
                      <canvas id="myAreaChart" width="669" height="320" class="chartjs-render-monitor" style="display: block; width: 669px; height: 320px;"></canvas>
                  </div>
              </div>
          </div>
      </div>

      <!-- Pie Chart -->
      <div class="col-xl-4 col-lg-5">
          <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header bg-primary py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-white">Total Lunas vs. Belum Lunas</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                      <div class="chartjs-size-monitor">
                          <div class="chartjs-size-monitor-expand">
                              <div class=""></div>
                          </div>
                          <div class="chartjs-size-monitor-shrink">
                              <div class=""></div>
                          </div>
                      </div>
                      <canvas id="myPieChart" width="302" height="245" class="chartjs-render-monitor" style="display: block; width: 302px; height: 245px;"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                      <span class="mr-2">
                          <i class="fas fa-circle text-primary"></i> Pemasukan
                      </span>
                      <span class="mr-2">
                          <i class="fas fa-circle text-danger"></i> Pengeluaran
                      </span>
                  </div>
              </div>
          </div>
      </div>

  </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

 
