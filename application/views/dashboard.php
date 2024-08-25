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
      <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total User</div>
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

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

 
