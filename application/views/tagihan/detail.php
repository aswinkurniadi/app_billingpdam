<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title;  ?></h1>

	<div class="row">
		<div class="col-sm-3">
			<div class="card border-bottom-primary shadow mb-4">
	            <div class="card-header py-3">
	            	<div class="row">
	            		<div class="col-sm-6">
				            <h6 class="m-0 font-weight-bold text-primary mt-2">Detail pelanggan</h6>
	            		</div>
	            		<div class="col-sm-6 text-right">
				            <a href="<?= base_url('pelanggan/detail/'.$dtByID->id_plng); ?>" target="_BLANK" class="badge badge-success">
                      			<span class="icon text-white-50">
                    			  	<i class="fas fa-fw fa-user"></i>
                    			</span>
                    			<span class="text">Detail</span>
                    		</a>
	            		</div>
	            	</div>
	            </div>
				<div class="card-body">

					<div class="col-sm">
						<div class="form-group row">
							<label for="no_plng" class="col-sm-4 form-label">ID PLNG</label>
							<div class="col-sm-8">
								<label><?= $dtByID->no_plng; ?></label>
						    </div>
						</div>
						<div class="form-group row">
							<label for="tgl" class="col-sm-4 form-label">Tanggal Pasang</label>
							<div class="col-sm-8">
								<label><?= $dtByID->tgl; ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="nm" class="col-sm-4 form-label">Nama</label>
							<div class="col-sm-8">
								<label><?= $dtByID->nm; ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="almt" class="col-sm-4 form-label">Alamat</label>
							<div class="col-sm-8">
								<label><?= $dtByID->almt; ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="no_telp" class="col-sm-4 form-label">Nomor Telp</label>
							<div class="col-sm-8">
								<label><?= $dtByID->no_telp; ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="nomor_air" class="col-sm-4 form-label">Nomor Air</label>
							<div class="col-sm-8">
								<label><?= $dtByID->nomor_air; ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="id_paket" class="col-sm-4 form-label">Paket</label>
							<div class="col-sm-8">
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
							<label for="stts" class="col-sm-4 form-label">Status</label>
							<div class="col-sm-8">
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

		<!-- riwayat tagihan -->
		<div class="col-sm-9">
			<div class="card border-bottom-primary shadow mb-4">
	            <div class="card-header py-3">
	            	<div class="row">
	            		<div class="col-sm-6">
				            <h6 class="m-0 font-weight-bold text-primary mt-2">Riwayat Tagihan Pelanggan</h6>
	            		</div>
	            		<div class="col-sm-6 text-right">
				            <a href="<?= base_url('pelanggan/ubah_stts_putus/'.$dtByID->id_plng); ?>" class="badge badge-primary tambahpiutang" data-toggle="modal" data-target="#newPiutangCustomer" data-id_plng="<?= $dtByID->id_plng; ?>" data-nm="<?= $dtByID->nm; ?>">
                      			<span class="icon text-white-50">
                    			  	<i class="fas fa-fw fa-plus"></i>
                    			</span>
                    			<span class="text">Tambah</span>
                    		</a>
	            		</div>
	            	</div>
	            </div>
				<div class="card-body">
					<div class="table-responsive">
				  		<table class="table table-striped table-hover table-sm" id="tabel-data">
						  <thead>
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Waktu</th>
						      <th scope="col">User</th>
						      <th scope="col">Metode Bayar</th>
						      <th scope="col">Dibayar</th>
						      <th scope="col">Diterima</th>
						      <th scope="col">Bulan</th>
						      <th scope="col">Debit</th>
						      <th scope="col">Kredit</th>
						      <th scope="col">Saldo</th>
						      <th scope="col">Ket</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>
						  	<?php 
						  	$no = 1;
							$saldo = 0;
						  	foreach($riw_tagihan as $row) { 
						  		if($row['type'] == 1) {
									$id_piut = $row['id_piutang_in'];
									$saldo += $row['nilai'];
								} else {
									$id_piut = $row['id_piutang_out'];
									$saldo -= $row['nilai'];
								}

					  		?>
						  	<tr>
						  		<td><?= $no++; ?></td>
						  		<td><?= $row['tgl']; ?></td>
						  		<td><?= $row['name']; ?></td>
						  		<td><?= $row['kas']; ?></td>
						  		<td><?= $row['dibayar']; ?></td>
						  		<td><?= $row['diterima']; ?></td>
						  		<td><?= $row['bln']; ?></td>
					  		<?php if($row['type'] == 1) { ?>
						  		<td align="right"><?= number_format($row['nilai'],0,',','.'); ?></td>
						  		<td></td>
						  	<?php } else { ?>
						  		<td></td>
						  		<td align="right"><?= number_format($row['nilai'],0,',','.'); ?></td>
						  	<?php } ?>
						  		<td align="right"><?= number_format($saldo,0,',','.'); ?></td>
						  		<td><?= $row['ket']; ?></td>
						  		<td>
						      	<?php if($row['type'] == 1) { ?>
						      		<div class="row" style="text-align: center;">
							      		<a href="" class="badge badge-primary edit_piutang mr-1" data-toggle="modal" data-target="#editPiutang"
						      				data-id_piut="<?= $id_piut; ?>"
							            	data-id_plng="<?= $dtByID->id_plng; ?>"
							      			data-nm="<?= $dtByID->nm; ?>"
							      			data-bln="<?= $row['bln']; ?>"
							      			data-tgl="<?= $row['tgl']; ?>"
							      			data-nilai="<?= $row['nilai']; ?>"
							      			data-id_kas="<?= $row['id_kas']; ?>"
							      			data-type="<?= $row['type']; ?>">
							      			<span class="icon text-white-50">
											  	<i class="fas fa-fw fa-edit"></i>
											</span>
							      		</a>
							      		<a href="<?= base_url(); ?>tagihan/deleteTagihanIn/<?= $id_piut; ?>" class="badge badge-danger mr-1" onclick="return confirm('Apakah ingin menghapus?');">
							      			<span class="icon text-white-50">
											  	<i class="fas fa-fw fa-trash"></i>
											</span>
							      		</a>
							      	</div>
					      		<?php } else { ?>
					      			<div class="row" style="text-align: center;">
						      			<a href="" class="badge badge-primary edit_piutang mr-1" data-toggle="modal" data-target="#editPiutang"
						      				data-id_piut="<?= $id_piut; ?>"
							            	data-id_plng="<?= $dtByID->id_plng; ?>"
							      			data-nm="<?= $dtByID->nm; ?>"
							      			data-bln="<?= $row['bln']; ?>"
							      			data-tgl="<?= $row['tgl']; ?>"
							      			data-nilai="<?= $row['nilai']; ?>"
							      			data-id_kas="<?= $row['id_kas']; ?>"
							      			data-type="<?= $row['type']; ?>">
							      			<span class="icon text-white-50">
											  	<i class="fas fa-fw fa-edit"></i>
											</span>
							      		</a>
							      		<a href="<?= base_url(); ?>tagihan/deleteTagihanOut/<?= $id_piut; ?> mr-1" class="badge badge-danger" onclick="return confirm('Apakah ingin menghapus?');">
							      			<span class="icon text-white-50">
											  	<i class="fas fa-fw fa-trash"></i>
											</span>
							      		</a>
							      	</div>
					      		<?php }; ?>
						      	</div>

						  	</tr>
						  	<?php } ?>
						  </tbody>
						</table>
					</div>
					
				</div>
			</div>
		</div>
		
	</div>

  </div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- Modal -->
<div class="modal fade" id="editPiutang" tabindex="-1" role="dialog" aria-labelledby="editPiutangLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPiutangLabel">Edit Tagihan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('receivablenew/editReceivable'); ?>" method="post">
	      <div class="modal-body">
	        <div class="form-group">
			    <input type="date" class="form-control" id="tgl_edit" name="tgl_edit" value="<?= $now; ?>" required="" readonly>
			</div>
			<div class="form-group">
				<input type="hidden" class="form-control" id="id_piut_edit" name="id_piut_edit" placeholder="ID" required="">
				<input type="hidden" class="form-control" id="id_plng_edit" name="id_plng_edit" placeholder="ID" required="">
				<input type="hidden" class="form-control" id="type_edit" name="type_edit" placeholder="ID" required="">
				<input type="text" class="form-control" id="nm_plng_edit" name="nm_plng_edit" placeholder="Nama Pelanggan" required="" readonly="">
			</div>
			<div class="form-group">
				<select class="form-control bootstrap-select" id="bln_edit2" name="bln_edit" class="form-control" title="Pilih Bulan" required>
					<option value="1">Januari</option>
					<option value="2">Februari</option>
					<option value="3">Maret</option>
					<option value="4">April</option>
					<option value="5">Mei</option>
					<option value="6">Juni</option>
					<option value="7">Juli</option>
					<option value="8">Agustus</option>
					<option value="9">September</option>
					<option value="10">Oktober</option>
					<option value="11">November</option>
					<option value="12">Desember</option>
				</select>
			</div>
			<div class="form-group">
		    	<select class="form-control bootstrap-select" id="kas_edit" name="kas_edit" title="Pilih Kas">
		    		<?php foreach ($datakas as $kas) : ?>
						<option value="<?= $kas['id_kas']; ?>"><?= $kas['nm_kas']; ?></option>
					<?php endforeach; ?>
	  			</select>
			</div>
			<div class="form-group">
			    <input type="text" class="form-control" id="value_edit" name="value_edit" placeholder="Nilai Piutang" required="">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Add</button>
	      </div>
      </form>
    </div>
  </div>
</div> 
<!-- Tambah piutang cust -->

<!-- Modal -->
<div class="modal fade" id="newPiutangCustomer" tabindex="-1" role="dialog" aria-labelledby="newPiutangCustomerLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newPiutangCustomerLabel">Add Tagihan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('tagihan/tambah_tagihan'); ?>" method="post">
	      <div class="modal-body">
	        <div class="form-group">
	        	<input type="hidden" class="form-control" id="user_id" name="user_id" placeholder="ID" value="<?= $user['id_user']; ?>" required="">
			    <input type="date" class="form-control" id="tgl" name="tgl" value="<?= $now; ?>" required="">
			</div>
			<div class="form-group">
				<input type="hidden" class="form-control" id="id_plng_tambah" name="id_plng" placeholder="ID" required="">
				<input type="text" class="form-control" id="nm_plng_tambah" name="nm_plng" placeholder="Nama Pelanggan" required="" readonly="">
			</div>
			<div class="form-group">
				<select class="form-control bootstrap-select" id="bln" name="bln" class="form-control" title="Pilih Bulan" required>
					<option value="1" <?= ($bulan == 1) ? "selected" : ""; ?>>Januari</option>
					<option value="2" <?= ($bulan == 2) ? "selected" : ""; ?>>Februari</option>
					<option value="3" <?= ($bulan == 3) ? "selected" : ""; ?>>Maret</option>
					<option value="4" <?= ($bulan == 4) ? "selected" : ""; ?>>April</option>
					<option value="5" <?= ($bulan == 5) ? "selected" : ""; ?>>Mei</option>
					<option value="6" <?= ($bulan == 6) ? "selected" : ""; ?>>Juni</option>
					<option value="7" <?= ($bulan == 7) ? "selected" : ""; ?>>Juli</option>
					<option value="8" <?= ($bulan == 8) ? "selected" : ""; ?>>Agustus</option>
					<option value="9" <?= ($bulan == 9) ? "selected" : ""; ?>>September</option>
					<option value="10" <?= ($bulan == 10) ? "selected" : ""; ?>>Oktober</option>
					<option value="11" <?= ($bulan == 11) ? "selected" : ""; ?>>November</option>
					<option value="12" <?= ($bulan == 12) ? "selected" : ""; ?>>Desember</option>
				</select>
			</div>
			<div class="form-group">
			    <input type="text" class="form-control" id="value_tambah" name="value" placeholder="Nilai Tagihan" required="">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Add</button>
	      </div>
      </form>      
    </div>
  </div>
</div> 
<!-- Tutup piutang cust -->




<script>
$(document).ready(function(){
	$('.tambahpiutang').on('click',function(){
	
	    var id_plng = $(this).data('id_plng');
	    var nm_plng = $(this).data('nm');

		console.log(nm_plng);

	    $("#id_plng_tambah").val(id_plng);
	    $("#nm_plng_tambah").val(nm_plng);
	});

	$('.pelunasan').on('click',function(){
	
	    var id_plng = $(this).data('id_plng');
	    var nm_plng = $(this).data('nm');
	    var tagih_awal = $(this).data('bayar');

	    var	number_string = tagih_awal.toString(),
			sisa 	= number_string.length % 3,
			rupiah 	= number_string.substr(0, sisa),
			ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
				
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

	    $("#id_plng").val(id_plng);
	    $("#nm_plng").val(nm_plng);
	    $("#value").val('Rp. ' + rupiah);
	});

	$('.edit_piutang').on('click',function(){
	
	    let id_piut = $(this).data('id_piut');
	    let id_plng = $(this).data('id_plng');
	    let nm_plng = $(this).data('nm');
	    let tgl = $(this).data('tgl');
	    let bln = $(this).data('bln'); 
	    let id_kas = $(this).data('id_kas'); 
	    let type = $(this).data('type'); 
	    let tagih_awal = $(this).data('nilai');

	    var	number_string = tagih_awal.toString(),
			sisa 	= number_string.length % 3,
			rupiah 	= number_string.substr(0, sisa),
			ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
				
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

	    $("#tgl_edit").val(tgl);
	    $("#id_piut_edit").val(id_piut);
	    $("#id_plng_edit").val(id_plng);
	    $("#nm_plng_edit").val(nm_plng);
	    $("#type_edit").val(type);
	    $("#kas_edit option[value='" + id_kas + "']").prop("selected", true).change();
	    $("#bln_edit2 option[value='" + bln + "']").prop("selected", true).change();
	    $("#value_edit").val('Rp. ' + rupiah);
	});
});

</script>