<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <div class="row justify-content-center">
    <div class="col-sm-10" id="edit-data-pelanggan">
      <div class="card border-bottom-primary shadow mb-4">
        <div class="card-header py-3">
          <div class="row">
            <div class="col-sm">
              <h6 class="m-0 font-weight-bold text-primary mt-2">Form <?= $title; ?></h6>
            </div>
          </div>
        </div>

        <div class="card-body">
            <form action="<?= base_url('pelanggan/update/'.$dtByID->id_plng); ?>" method="post">
            <div class="row">
              <div class="col-sm-6">
              
                <!-- ID Pelanggan (readonly) -->
                <div class="form-group row">
                  <label for="no_plng" class="col-sm-2 col-form-label">ID PLNG</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?= $dtByID->no_plng; ?>" readonly>
                  </div>
                </div>

                <!-- Tanggal Pasang -->
                <div class="form-group row">
                  <label for="tgl" class="col-sm-2 col-form-label">Tanggal Pasang</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" id="tgl" name="tgl" value="<?= $dtByID->tgl; ?>" required>
                  </div>
                </div>

                <!-- Nama -->
                <div class="form-group row">
                  <label for="nm" class="col-sm-2 col-form-label">Nama</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="nm" name="nm" value="<?= $dtByID->nm; ?>" required>
                  </div>
                </div>

                <!-- Alamat -->
                <div class="form-group row">
                  <label for="almt" class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="almt" name="almt" rows="3" required><?= $dtByID->almt; ?></textarea>
                  </div>
                </div>

                <!-- No Telp -->
                <div class="form-group row">
                  <label for="no_telp" class="col-sm-2 col-form-label">Nomor Telp</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= $dtByID->no_telp; ?>" required>
                  </div>
                </div>

                <!-- Nomor Air -->
                <div class="form-group row">
                  <label for="nomor_air" class="col-sm-2 col-form-label">Nomor Air</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="nomor_air" name="nomor_air" value="<?= $dtByID->nomor_air; ?>" required>
                  </div>
                </div>

                <!-- Status -->
                <div class="form-group row">
                  <label for="stts" class="col-sm-2 col-form-label">Status</label>
                  <div class="col-sm-10">
                    <select class="form-control selectpicker" name="stts" required>
                      <option value="1" <?= ($dtByID->stts == 1) ? 'selected' : ''; ?>>Aktif</option>
                      <option value="0" <?= ($dtByID->stts == 0) ? 'selected' : ''; ?>>Tidak Aktif</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">

                <!-- Email -->
                <div class="form-group row">
                  <label for="email" class="col-sm-2 form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Alamat Email" required>
                  </div>
                </div>

                <!-- Username -->
                <div class="form-group row">
                  <label for="username" class="col-sm-2 form-label">Username</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                  </div>
                </div>

                <!-- Password -->
                <div class="form-group row">
                  <label for="password" class="col-sm-2 form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                  </div>
                </div>

              </div>
            </div>

            <hr class="mb-3 mt-3">

            <!-- Tombol Simpan -->
            <div class="row">
              <div class="col-sm text-right">
                <button type="submit" class="btn btn-primary btn-md">
                  <span class="icon text-white-50"><i class="fas fa-save"></i></span>
                  <span class="text">Simpan</span>
                </button>
              </div>
            </div>

            </form>
        </div>

      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

