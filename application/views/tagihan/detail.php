<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">

	  <!-- Page Heading -->
	  <h1 class="h3 mb-4 text-gray-800"><?= $title;  ?></h1>

 	</div>	

  	<div class="row clearfix">
	  	<div class="col-lg-12">

			<?= $this->session->flashdata('message'); ?>
			
		</div>
	</div>

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
				            <a href="<?= base_url('pelanggan/ubah_stts_putus/'.$dtByID->id_plng); ?>" class="btn btn-primary btn-sm tambahpiutang" data-toggle="modal" data-target="#newPiutangCustomer" data-id_plng="<?= $dtByID->id_plng; ?>" data-nm="<?= $dtByID->nm; ?>">
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
						      <th scope="col">Detail</th>
						      <th scope="col">Timestamp</th>
						      <th scope="col">Tanggal</th>
						      <th scope="col">User</th>
						      <th scope="col">Bulan</th>
						      <th scope="col">Tagihan</th>
						      <th scope="col">Terlunasi</th>
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
									$id_piut = $row['id_piut'];
									$saldo = $row['nilai_tagihan'] - $row['nilai_terlunasi'];
					  		?>
						  	<tr>
						  		<td><?= $no++; ?></td>
						  		<td>
						      		<div class="row" style="text-align: center;">

							      		<a href="" class="badge badge-success detail_piutang_in mr-1" data-toggle="modal" data-target="#detailPiutangIn"
						      				data-id_piut="<?= $id_piut; ?>">
													  	<i class="fas fa-fw fa-list"></i>			
										        <span class="text">Detail Tagihan</span>
							      		</a>

							      	</div>
					      	</td>
						  		<td><?= $row['date_created']; ?></td>
						  		<td><?= $row['tgl']; ?></td>
						  		<td><?= $row['name']; ?></td>
						  		<td><?= $row['bln']; ?></td>
						  		<td align="right"><?= number_format($row['nilai_tagihan'],0,',','.'); ?></td>
						  		<td align="right"><?= number_format($row['nilai_terlunasi'],0,',','.'); ?></td>
						  		<td align="right"><?= number_format($saldo,0,',','.'); ?></td>
						  		<td><?= $row['ket']; ?></td>
						  		<td>
						      		<div class="row" style="text-align: center;">
						      			<?php if($saldo != 0) { ?>
						            <a href="" class="btn btn-success btn-sm pelunasan mb-2 mr-2" data-toggle="modal" data-target="#newPiutang"
								            data-id_piut="<?= $id_piut; ?>"
								            data-id_plng="<?= $dtByID->id_plng; ?>"
								      			data-nm="<?= $dtByID->nm; ?>"
								      			data-nilai="<?= $row['nilai_tagihan']; ?>">
										        <i class="fas fa-fw fa-plus fa-sm text-white-50"></i>
										        <span class="text">Pelunasan</span>
										    </a>
										  <?php } ?>

							      		<a href="<?= base_url(); ?>tagihan/deleteTagihanIn/<?= $id_piut; ?>" class="btn btn-sm btn-danger mb-2" onclick="return confirm('Apakah ingin menghapus? Semua detail pada piutang in, akan terhapus');">

											  	<i class="fas fa-fw fa-trash"></i>
									        <span class="text">Hapus</span>
							      		</a>
							      	</div>
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
<div class="modal fade" id="newPiutang" tabindex="-1" role="dialog" aria-labelledby="newPiutangLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newPiutangLabel">Pelunasan tagihan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('tagihan/tambah_pelunasan'); ?>" method="post">
	      <div class="modal-body">
	        <div class="form-group">
			    <input type="date" class="form-control" id="tgl" name="tgl" value="<?= $now; ?>" required="">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Nama Pelanggan" value="Akun : <?= $user['name']; ?>" readonly="" required="">
			</div>
			<div class="form-group">
				<input type="hidden" class="form-control" id="id_piut_lunas" name="id_piut" placeholder="ID" required="">
				<input type="hidden" class="form-control" id="id_plng_lunas" name="id_plng" placeholder="ID" required="">
				<input type="text" class="form-control" id="nm_plng_lunas" name="nm_plng" placeholder="Nama Pelanggan" readonly="" required="">
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
			    <input type="text" class="form-control" id="value_lunas" name="value" placeholder="Nilai Piutang" required="">
			</div>
			<div class="form-group">
		    	<select type="text" class="form-control bootstrap-select" id="kas" name="kas" title="Pilih Kas" data-container="body" data-live-search="true" required>
		    		<?php foreach ($datakas as $kas) : ?>
						<option value="<?= $kas['id_kas']; ?>"><?= $kas['nm_kas']; ?></option>
					<?php endforeach; ?>
	  			</select>
			</div>
			<div class="form-group">
			    <input type="text" class="form-control" id="dibayar" name="dibayar" placeholder="Nama Pembayar" value="" required="">
			</div>
			<div class="form-group">
			    <input type="text" class="form-control" id="diterima" name="diterima" placeholder="Nama Penerima" value="" required="">
			</div>
			<div class="form-group">
			    <input type="text" class="form-control" id="ket" name="ket" placeholder="Keterangan" value="" required="">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Simpan</button>
	      </div>
      </form>      
    </div>
  </div>
</div> 


<script type="text/javascript">

$(document).ready(function(){
	$('.pelunasan').on('click',function(){
	
	    var id_piut = $(this).data('id_piut');
	    var id_plng = $(this).data('id_plng');
	    var nm_plng = $(this).data('nm');
	    var tagih_awal = $(this).data('nilai');

	    var	number_string = tagih_awal.toString(),
				sisa 	= number_string.length % 3,
				rupiah 	= number_string.substr(0, sisa),
				ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
					
			if (ribuan) {
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

	    $("#id_piut_lunas").val(id_piut);
	    $("#id_plng_lunas").val(id_plng);
	    $("#nm_plng_lunas").val(nm_plng);
	    $("#value_lunas").val('Rp. ' + rupiah);
	});
});

</script>

<!-- Modal -->
<div class="modal fade" id="newPiutangCustomer" tabindex="-1" role="dialog" aria-labelledby="newPiutangCustomerLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newPiutangCustomerLabel">Tambah Tagihan Manual</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('tagihan/tambah_tagihan'); ?>" method="post">
	      <div class="modal-body">
	        <div class="form-group">
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
			<div class="form-group">
			    <input type="text" class="form-control" id="ket" name="ket" placeholder="Keterangan Tambahan">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Simpan</button>
	      </div>
      </form>      
    </div>
  </div>
</div> 
<!-- Tutup piutang cust -->

<!-- menampilkan detail dari piutang in (dari controller) -->
<div class="modal fade" id="detailPiutangIn" tabindex="-1" role="dialog" aria-labelledby="detailPiutangInLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailPiutangInLabel">Detail Tagihan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        	<!-- menampilkan modal dari sini -->

      </div>
      <div class="modal-footer">
      </div> 
    </div>
  </div>
</div> 


<script type="text/javascript">
	
$(document).ready(function(){
	$('.tambahpiutang').on('click',function(){
	
	    var id_plng = $(this).data('id_plng');
	    var nm_plng = $(this).data('nm');

	    $("#id_plng_tambah").val(id_plng);
	    $("#nm_plng_tambah").val(nm_plng);
	});

	// script ajax ambil data dari database
  // ketika tombol detail diklik
  $(document).on("click", ".detail_piutang_in", function(e) {
    e.preventDefault();

    let id_piut = $(this).data("id_piut");

    // kosongkan isi modal dulu agar tidak menumpuk
    $("#detailPiutangIn .modal-body").html('<p class="text-center text-muted">Loading data...</p>');

    // panggil controller via AJAX
    $.ajax({
      url: "<?= base_url('tagihan/get_detail_piutang_in'); ?>",
      type: "POST",
      data: { id_piut: id_piut },
      dataType: "html", // kita terima HTML langsung
      success: function(response) {

        $("#detailPiutangIn .modal-body").html(response);
      },
      error: function(xhr, status, error) {
        console.error(error);
        $("#detailPiutangIn .modal-body").html('<div class="alert alert-danger">Gagal memuat data!</div>');
      }
    });
  });

});

</script>


<!-- Modal -->
<div class="modal fade" id="editPiutangIn" tabindex="-1" role="dialog" aria-labelledby="editPiutangInLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPiutangInLabel">Ubah Tagihan In</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('tagihan/ubah_tagihan'); ?>" method="post">
	      <div class="modal-body">
	        <div class="form-group">
			    <input type="date" class="form-control" id="tgl_edit" name="tgl_edit" required="" readonly>
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
			    <input type="text" class="form-control" id="value_edit" name="value_edit" placeholder="Nilai Piutang" required="">
			</div>
			<div class="form-group">
			    <input type="text" class="form-control" id="ket_edit" name="ket" placeholder="Alasan penambahan tagihan manual">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Simpan</button>
	      </div>
      </form>
    </div>
  </div>
</div> 
<!-- Tambah piutang cust -->



<!-- Modal -->
<div class="modal fade" id="editPiutangOut" tabindex="-1" role="dialog" aria-labelledby="editPiutangOutLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPiutangOutLabel">Ubah Tagihan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('tagihan/ubah_tagihan'); ?>" method="post">
	      <div class="modal-body">
	        <div class="form-group">
			    <input type="date" class="form-control" id="tgl_edit1" name="tgl_edit" required="" readonly>
			</div>
			<div class="form-group">
				<input type="hidden" class="form-control" id="id_piut_edit1" name="id_piut_edit" placeholder="ID" required="">
				<input type="hidden" class="form-control" id="id_plng_edit1" name="id_plng_edit" placeholder="ID" required="">
				<input type="hidden" class="form-control" id="type_edit1" name="type_edit" placeholder="ID" required="">
				<input type="text" class="form-control" id="nm_plng_edit1" name="nm_plng_edit" placeholder="Nama Pelanggan" required="" readonly="">
			</div>
			<div class="form-group">
				<select class="form-control bootstrap-select" id="bln_edit3" name="bln_edit" class="form-control" title="Pilih Bulan" required>
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
		    	<select class="form-control bootstrap-select" id="kas_edit1" name="kas_edit" title="Pilih Kas">
		    		<?php foreach ($datakas as $kas) : ?>
						<option value="<?= $kas['id_kas']; ?>"><?= $kas['nm_kas']; ?></option>
					<?php endforeach; ?>
	  			</select>
			</div>
			<div class="form-group">
			    <input type="text" class="form-control" id="value_edit1" name="value_edit" placeholder="Nilai Piutang" required="">
			</div>
			<div class="form-group">
			    <input type="text" class="form-control" id="dibayar_edit" name="dibayar" placeholder="Dibayar Oleh" required="">
			</div>
			<div class="form-group">
			    <input type="text" class="form-control" id="diterima_edit" name="diterima" placeholder="Diterima Oleh" required="">
			</div>
			<div class="form-group">
			    <input type="text" class="form-control" id="ket_edit1" name="ket" placeholder="Alasan penambahan tagihan manual">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Simpan</button>
	      </div>
      </form>
    </div>
  </div>
</div> 
<!-- Tambah piutang cust -->

<script>


$(document).ready(function(){

	$(document).on("keyup", "[id^='value']", function() {
	// Menangani Input otomatis Format Ribuan
	let rupiah = $(this).val();

	$(this).val(formatRupiah(rupiah, 'Rp. '));

	/* Fungsi formatRupiah */
	function formatRupiah(angka, prefix) {
		let number_string = angka.replace(/[^,\d]/g, '').toString(),
			split = number_string.split(','),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);

		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
	}
});


	$('.edit_piutang_in').on('click',function(){
	
	    let id_piut = $(this).data('id_piut');
	    let id_plng = $(this).data('id_plng');
	    let nm_plng = $(this).data('nm');
	    let tgl = $(this).data('tgl');
	    let bln = $(this).data('bln'); 
	    let id_kas = $(this).data('id_kas'); 
	    let type = $(this).data('type'); 
	    let tagih_awal = $(this).data('nilai');
	    let ket = $(this).data('ket');

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
	    $("#ket_edit").val(ket);
	    $("#type_edit").val(type);
	    $("#kas_edit option[value='" + id_kas + "']").prop("selected", true).change();
	    $("#bln_edit2 option[value='" + bln + "']").prop("selected", true).change();
	    $("#value_edit").val('Rp. ' + rupiah);
	});


	$('.edit_piutang_out').on('click',function(){
	
	    let id_piut = $(this).data('id_piut');
	    let id_plng = $(this).data('id_plng');
	    let nm_plng = $(this).data('nm');
	    let tgl = $(this).data('tgl');
	    let bln = $(this).data('bln'); 
	    let id_kas = $(this).data('id_kas'); 
	    let type = $(this).data('type'); 
	    let tagih_awal = $(this).data('nilai');
	    let ket = $(this).data('ket');
	    let dibayar = $(this).data('dibayar');
	    let diterima = $(this).data('diterima');

	    var	number_string = tagih_awal.toString(),
			sisa 	= number_string.length % 3,
			rupiah 	= number_string.substr(0, sisa),
			ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
				
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

	    $("#tgl_edit1").val(tgl);
	    $("#id_piut_edit1").val(id_piut);
	    $("#id_plng_edit1").val(id_plng);
	    $("#nm_plng_edit1").val(nm_plng);
	    $("#ket_edit1").val(ket);
	    $("#dibayar_edit").val(dibayar);
	    $("#diterima_edit").val(diterima);
	    $("#type_edit1").val(type);
	    $("#kas_edit1 option[value='" + id_kas + "']").prop("selected", true).change();
	    $("#bln_edit3 option[value='" + bln + "']").prop("selected", true).change();
	    $("#value_edit1").val('Rp. ' + rupiah);
	});
});

</script>