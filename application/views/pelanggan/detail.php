<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800 mb-3"><?= $title;  ?></h1>
      <div>
      </div>
  </div>

  <!-- Page Heading -->

  <div class="row">
    <div class="col-sm">
      <div class="card border-bottom-primary shadow mb-4">
        <div class="card-header py-3">
          <div class="row">
            <div class="col-sm-4">
              <h6 class="m-0 font-weight-bold text-primary mt-2">Detail Pelanggan</h6>
            </div>
            <div class="col-sm-8 text-right">
              <?php if ($dtByID->stts != 2) { ?>
                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#berhenti_berlangganan">
                  <i class="fas fa-fw fa-stop text-white-50"></i>
                  <span class="text">Berhenti Langganan</span>
                </a>
              <?php } else { ?>
                <a href="<?= base_url('pelanggan/ubah_stts_aktif/' . $dtByID->id_plng); ?>" class="btn btn-sm btn-success">
                  <i class="fas fa-fw fa-play text-white-50"></i>
                  <span class="text">Aktifkan User</span>
                </a>
              <?php } ?>

                <a href="" class="btn btn-sm btn-warning shadow-sm" data-toggle="modal" data-target="#tambahpaket">
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i>
                    <span class="text">Tambah Subsidi</span>
                </a>
                <a href="" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambahpaket">
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i>
                    <span class="text">Tambah Denda</span>
                </a>
                <a href="" class="btn btn-sm btn-info shadow-sm" data-toggle="modal" data-target="#tambahpaket">
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i>
                    <span class="text">Tambah Catat Meter</span>
                </a>
                <a href="<?= base_url('dashboard/dashboard2'); ?>" class="btn btn-sm btn-success shadow-sm">
                    <i class="fas fa-fw fa-folder fa-sm text-white-50"></i>
                    <span class="text">Detail</span>
                </a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="col-sm">
            <div class="form-group row">
              <label class="col-sm-2 form-label">ID PLNG</label>
              <div class="col-sm-10">
                <label><?= $dtByID->no_plng; ?></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 form-label">Tanggal Pasang</label>
              <div class="col-sm-10">
                <label><?= $dtByID->tgl; ?></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 form-label">Nama</label>
              <div class="col-sm-10">
                <label><?= $dtByID->nm; ?></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 form-label">Alamat</label>
              <div class="col-sm-10">
                <label><?= $dtByID->almt; ?></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 form-label">Nomor Telp</label>
              <div class="col-sm-10">
                <label><?= $dtByID->no_telp; ?></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 form-label">Nomor Air</label>
              <div class="col-sm-10">
                <label><?= $dtByID->nomor_air; ?></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 form-label">Status</label>
              <div class="col-sm-10">
                <label><?= ($dtByID->stts == 1) ? "Aktif" : (($dtByID->stts == 0) ? "Tidak Aktif" : "Berhenti"); ?></label>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Jika pelanggan berhenti langganan -->
    <?php if ($dtByID->stts == 2) { ?>
      <div class="col-sm-4">
        <div class="card border-bottom-danger shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">Alasan Berhenti</h6>
          </div>
          <div class="card-body">
            <label><strong>Tanggal:</strong> <?= $dt_berhenti['tgl']; ?></label><br>
            <label><strong>Keterangan:</strong></label>
            <p><?= $dt_berhenti['ket']; ?></p>
          </div>
        </div>
      </div>
    <?php } ?>

  </div>
</div>
<!-- /.container-fluid -->

<!-- Modal Berhenti Berlangganan -->
<div class="modal fade" id="berhenti_berlangganan" tabindex="-1" role="dialog" aria-labelledby="berhenti_berlanggananLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('pelanggan/ubah_stts_putus/' . $dtByID->id_plng); ?>" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Berhenti Berlangganan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label>Alasan berhenti berlangganan</label>
          <textarea name="ket" class="form-control" placeholder="Masukkan alasan..." rows="3" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

