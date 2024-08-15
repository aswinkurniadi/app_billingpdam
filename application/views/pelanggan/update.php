<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title;  ?></h1>

	<div class="row justify-content-center">
		<div class="col-sm-8" id="add-data-account">
			<div class="card border-bottom-primary shadow mb-4">
	            <div class="card-header py-3">
	            	<div class="row">
	            		<div class="col-sm">
				            <h6 class="m-0 font-weight-bold text-primary mt-2">Form <?= $title;  ?></h6>
	            		</div>
	            	</div>
	            </div>
				<div class="card-body">
					<div class="col-sm">
						<form action="<?= base_url('pelanggan/update/'.$dtByID->id_plng); ?>" method="post">
							<div class="form-group row">
								<label for="no_plng" class="col-sm-2 form-label">ID PLNG</label>
								<div class="col-sm-10">
								    <input type="number" class="form-control" placeholder="Nomor Pelanggan" autocomplete="off" value="<?= $dtByID->no_plng; ?>" readonly="" required>
							    </div>
							</div>
							<div class="form-group row">
								<label for="tgl" class="col-sm-2 form-label">Tanggal Pasang</label>
								<div class="col-sm-10">
								    <input type="date" class="form-control" id="tgl" name="tgl" value="<?= $dtByID->tgl; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="nm" class="col-sm-2 form-label">Nama</label>
								<div class="col-sm-10">
								    <input type="text" class="form-control" id="nm" name="nm" placeholder="Nama Pelanggan" autocomplete="off" value="<?= $dtByID->nm; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="almt" class="col-sm-2 form-label">Alamat</label>
								<div class="col-sm-10">
								    <textarea class="form-control" id="almt" name="almt" cols="30" rows="5" placeholder="Alamat Pelanggan" required><?= $dtByID->almt; ?></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label for="no_telp" class="col-sm-2 form-label">Nomor Telp</label>
								<div class="col-sm-10">
								    <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="No Telp Pelanggan" value="<?= $dtByID->no_telp; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="nomor_air" class="col-sm-2 form-label">Nomor Air</label>
								<div class="col-sm-10">
								    <input type="number" class="form-control" id="nomor_air" name="nomor_air" placeholder="Nomor Air" autocomplete="off" value="<?= $dtByID->nomor_air; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="id_paket" class="col-sm-2 form-label">Paket</label>
								<div class="col-sm-10">
									<select class="form-control bootstrap-select" name="id_paket" class="form-control" title="Pilih Paket" data-live-search="true">
										<?php foreach ($dt_paket as $row) : ?>
											<?= $selected = ($row['id_paket'] == $dtByID->id_paket) ? 'selected' : null; ?>
											<option value="<?= $row['id_paket']; ?>" <?= $selected; ?>><?= $row['nama']; ?> ( <?= number_format($row['nilai']); ?> )</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label for="stts" class="col-sm-2 form-label">Status</label>
								<div class="col-sm-10">
								    <select class="form-control bootstrap-select" id="stts" name="stts" class="form-control" title="Status" required>
										<option value="1" <?= ($dtByID->stts == 1) ? 'selected' : null; ?>>Aktif</option>
										<option value="0" <?= ($dtByID->stts == 0) ? 'selected' : null; ?>>Tidak Aktif</option>
									</select>
								</div>
							</div>
							<hr class="mb-3 mt-3">
							<div class="row">
								<div class="col-sm text-right">
							    	<button type="submit" class="btn btn-primary btn-md">
							    	<span class="icon text-white-50">
							          <i class="fas fa-fw fa-save"></i>
							        </span>
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

  </div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

