<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title;  ?></h1>

	<div class="row justify-content-center">
		<div class="col-sm-6" id="add-data-account">
			<div class="card border-bottom-primary shadow mb-4">
	            <div class="card-header py-3">
	            	<div class="row">
					    <div class="col-sm">
				            <h6 class="m-0 font-weight-bold text-primary mt-2">Detail pelanggan sebagai berikut: </h6>
	            		</div>
	            		<div class="col-sm text-right">
	            		    <a href="<?= base_url('tagihan/laporan_pelunasan'); ?>" class="btn btn-secondary btn-sm pelunasan">
						        <i class="fas fa-fw fa-arrow-left fa-sm text-white-50"></i>
						        <span class="text">Back</span>
						    </a>
					    </div>
	            	</div>
	            </div>
				<div class="card-body">
					<div class="col-sm">
						<div class="form-group row">
							<label for="nama" class="col-sm-3 col-form-label">Tgl</label>
			    			<div class="col-sm-9">
							    <input type="datetime-local" class="form-control" id="tgl" name="tgl" value="<?= $dtPelunasan['waktu']; ?>" required="" readonly="">
							</div>
						</div>
						<div class="form-group row">
							<label for="kode" class="col-sm-3 col-form-label">ID PLNG</label>
			    			<div class="col-sm-9">
								<label for="kode" class="col-form-label"><?= $dtPelunasan['no_plng']; ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="nama" class="col-sm-3 col-form-label">Nama</label>
			    			<div class="col-sm-9">
								<label for="nama" class="col-form-label"><?= $dtPelunasan['nm']; ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
			    			<div class="col-sm-9">
								<label for="alamat" class="col-form-label"><?= $dtPelunasan['almt']; ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="no_telp" class="col-sm-3 col-form-label">Nomor Telp</label>
			    			<div class="col-sm-9">
								<label for="no_telp" class="col-form-label"><?= $dtPelunasan['no_telp']; ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="paket" class="col-sm-3 col-form-label">Paket</label>
			    			<div class="col-sm-9">
								<label for="paket" class="col-form-label"><?= $dtPelunasan['paket']; ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="bln" class="col-sm-3 col-form-label">Bulan</label>
			    			<div class="col-sm-9">
								<select class="form-control bootstrap-select" class="form-control" title="Pilih Bulan" required disabled="">
									<option value="1" <?= ($dtPelunasan['bln'] == 1) ? "selected" : ""; ?>>Januari</option>
									<option value="2" <?= ($dtPelunasan['bln'] == 2) ? "selected" : ""; ?>>Februari</option>
									<option value="3" <?= ($dtPelunasan['bln'] == 3) ? "selected" : ""; ?>>Maret</option>
									<option value="4" <?= ($dtPelunasan['bln'] == 4) ? "selected" : ""; ?>>April</option>
									<option value="5" <?= ($dtPelunasan['bln'] == 5) ? "selected" : ""; ?>>Mei</option>
									<option value="6" <?= ($dtPelunasan['bln'] == 6) ? "selected" : ""; ?>>Juni</option>
									<option value="7" <?= ($dtPelunasan['bln'] == 7) ? "selected" : ""; ?>>Juli</option>
									<option value="8" <?= ($dtPelunasan['bln'] == 8) ? "selected" : ""; ?>>Agustus</option>
									<option value="9" <?= ($dtPelunasan['bln'] == 9) ? "selected" : ""; ?>>September</option>
									<option value="10" <?= ($dtPelunasan['bln'] == 10) ? "selected" : ""; ?>>Oktober</option>
									<option value="11" <?= ($dtPelunasan['bln'] == 11) ? "selected" : ""; ?>>November</option>
									<option value="12" <?= ($dtPelunasan['bln'] == 12) ? "selected" : ""; ?>>Desember</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="value" class="col-sm-3 col-form-label">Pilih Metode</label>
			    			<div class="col-sm-9">
						    	<select type="text" class="form-control bootstrap-select" class="form-control" title="Pilih Bulan" required disabled="">

        						<?php 
        						foreach ($dtByIDkas as $kas) : 
        						    ?>
						    		<option value="<?= $kas['id_kas']; ?>" <?= ($dtPelunasan['id_kas'] == $kas['id_kas']) ? "selected" : ""; ?>><?= $kas['nm_kas']; ?></option>
        						<?php endforeach; ?>
					  			</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="value" class="col-sm-3 col-form-label">Tagihan Aktif</label>
			    			<div class="col-sm-9">
							    <input type="text" class="form-control" id="value" name="value" placeholder="Nilai Piutang" value="<?= number_format($dtPelunasan['value']); ?>" required="" readonly="">
							</div>
						</div>
						<div class="form-group row">
							<label for="value" class="col-sm-3 col-form-label">Dibayar oleh : </label>
			    			<div class="col-sm-9">
							    <input type="text" class="form-control" id="dibayar" name="dibayar" placeholder="Nama Pembayar" value="<?= $dtPelunasan['dibayar']; ?>" required="" readonly="">
							</div>
						</div>
						<div class="form-group row">
							<label for="value" class="col-sm-3 col-form-label">Diterima oleh :</label>
			    			<div class="col-sm-9">
							    <input type="text" class="form-control" id="diterima" name="diterima" placeholder="Nama Penerima" value="<?= $dtPelunasan['diterima']; ?>" required="" readonly="">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-secondary shadow-sm" onclick="ajax_print('<?= base_url('tagihan/print_struct?'.$myarray); ?>',this)">
				  			<i class="fas fa-fw fa-print fa-sm text-white-50"></i>
				  			<span class="text">Cetak Nota</span>
				  		</button>
				     </div>
				</div>
			</div>
		</div>
		
	</div>

  </div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

 <script type="text/javascript">
        function ajax_print(url, btn) {
            $.get(url, function (data) {
                var ua = navigator.userAgent.toLowerCase();
                var isAndroid = ua.indexOf("android") > -1;
                if(isAndroid) {
                    android_print(data);
                }else{
                    pc_print(data);
                }
            });
        }

        function android_print(data){
            window.location.href = data;
        }
        
        function pc_print(data){
            var socket = new WebSocket("ws://127.0.0.1:40213/");
            socket.bufferType = "arraybuffer";
            socket.onerror = function(error) {
              alert("Error");
            };
            socket.onopen = function() {
                socket.send(data);
                socket.close(1000, "Work complete");
            };
        }
</script>