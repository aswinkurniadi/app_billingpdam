<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title;  ?></h1>

	<div class="row">
		<div class="col-sm-8">
			<div class="card border-bottom-primary shadow mb-4">
	            <div class="card-header py-3">
	            	<div class="row">
	            		<div class="col-sm-6">
				            <h6 class="m-0 font-weight-bold text-primary mt-2">Detail pelanggan</h6>
	            		</div>
	            		<div class="col-sm-6 text-right">				            
	            		    <?php if ($dtByID->stts != 2) { ?>
	            			<a href="<?= base_url('pelanggan/ubah_stts_putus/'.$dtByID->id_plng); ?>" class="badge badge-danger">
                      			<span class="icon text-white-50">
                    			  	<i class="fas fa-fw fa-stop"></i>
                    			</span>
                    			<span class="text">Berhenti langganan</span>
                    		</a>
							<?php } else { ?>
							<a href="<?= base_url('pelanggan/ubah_stts_aktif/'.$dtByID->id_plng); ?>" class="badge badge-success">
				      			<span class="icon text-white-50">
								  	<i class="fas fa-fw fa-stop"></i>
								</span>
								<span class="text">Aktifkan User</span>
							</a>
							<?php } ?>
	            		</div>
	            	</div>
	            </div>
				<div class="card-body">
					<div class="col-sm">
							<div class="form-group row">
								<label for="no_plng" class="col-sm-2 form-label">ID PLNG</label>
								<div class="col-sm-10">
									<label><?= $dtByID->no_plng; ?></label>
							    </div>
							</div>
							<div class="form-group row">
								<label for="tgl" class="col-sm-2 form-label">Tanggal Pasang</label>
								<div class="col-sm-10">
									<label><?= $dtByID->tgl; ?></label>
								</div>
							</div>
							<div class="form-group row">
								<label for="nm" class="col-sm-2 form-label">Nama</label>
								<div class="col-sm-10">
									<label><?= $dtByID->nm; ?></label>
								</div>
							</div>
							<div class="form-group row">
								<label for="almt" class="col-sm-2 form-label">Alamat</label>
								<div class="col-sm-10">
									<label><?= $dtByID->almt; ?></label>
								</div>
							</div>
							<div class="form-group row">
								<label for="no_telp" class="col-sm-2 form-label">Nomor Telp</label>
								<div class="col-sm-10">
									<label><?= $dtByID->no_telp; ?></label>
								</div>
							</div>
							<div class="form-group row">
								<label for="nomor_air" class="col-sm-2 form-label">Nomor Air</label>
								<div class="col-sm-10">
									<label><?= $dtByID->nomor_air; ?></label>
								</div>
							</div>
							<div class="form-group row">
								<label for="id_paket" class="col-sm-2 form-label">Paket</label>
								<div class="col-sm-10">
									<label>
										<?php 
											foreach ($dt_paket as $row) :
												if($row['id_paket'] == $dtByID->id_paket) {
													echo $row['nama'].' (Rp. '.number_format($row['nilai']).' ,-)';
												}
											endforeach;
										?>
									</label>
								</div>
							</div>
							<div class="form-group row">
								<label for="stts" class="col-sm-2 form-label">Status</label>
								<div class="col-sm-10">
									<label>
										<?php 
											if($dtByID->stts == 1) {
												echo "Aktif";
											} else {
												echo "Tidak Aktif";
											}
										?>
									</label>
								</div>
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

