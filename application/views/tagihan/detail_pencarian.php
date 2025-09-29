<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title;  ?></h1>

    <div class="row clearfix">
	  	<div class="col-lg-12">

			<?= $this->session->flashdata('message'); ?>
			
		</div>
	</div>
	
	<div class="row justify-content-center">
		<div class="col-sm-6" id="add-dtByID-account">
			<div class="card border-bottom-primary shadow mb-4">
	            <div class="card-header py-3">
	            	<div class="row">
	            		<div class="col-sm-6">
				            <h6 class="m-0 font-weight-bold text-primary mt-2">Detail pelanggan sebagai berikut: </h6>
	            		</div>
	            		<div class="col-sm-6 text-right">
				            <a href="<?= base_url('tagihan/cari_pelanggan'); ?>" class="btn btn-sm btn-secondary shadow-sm text-left">
						        <i class="fas fa-fw fa-search fa-sm text-white-50"></i>
						        <span class="text">Back to Search</span>
						    </a>
	            		</div>
	            	</div>
	            </div>
				<div class="card-body">
					<form action="<?= base_url('tagihan/pelunasan'); ?>" method="post">
					<div class="col-sm">
						<div class="form-group row">
							<label for="nama" class="col-sm-3 col-form-label">Tgl</label>
			    			<div class="col-sm-9">
			    				<input type="hidden" class="form-control" id="id_plng" name="id_plng" placeholder="ID" value="<?= $dtByID->id_plng; ?>" required="">
							    <input type="datetime-local" class="form-control" id="tgl" name="tgl" value="<?= $now; ?>" required="" readonly="">
							</div>
						</div>
						<div class="form-group row">
							<label for="kode" class="col-sm-3 col-form-label">No PLNG</label>
			    			<div class="col-sm-9">
								<label for="no_plng" class="col-form-label"><?= $dtByID->no_plng; ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="nama" class="col-sm-3 col-form-label">Nama</label>
			    			<div class="col-sm-9">
								<label for="nama" class="col-form-label"><?= $dtByID->nm ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
			    			<div class="col-sm-9">
								<label for="alamat" class="col-form-label"><?= $dtByID->almt ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="no_telp" class="col-sm-3 col-form-label">Nomor Telp</label>
			    			<div class="col-sm-9">
								<label for="no_telp" class="col-form-label"><?= $dtByID->no_telp ?></label>
							</div>
						</div>
						<div class="form-group row">
							<label for="bln" class="col-sm-3 col-form-label">Bulan
							<button id="button_bln_sekarang" class="btn btn-sm btn-success">Saat ini</button> </label>
							<input type="hidden" class="form-control" id="bln_sekarang" name="bln_sekarang" value="<?= $bulan; ?>" required="">
			    			<div class="col-sm-9">
								<select class="form-control bootstrap-select" id="bln_saat_ini" name="bln" class="form-control" title="Pilih Bulan" required>
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
						</div>
						
						<style type="text/css">
        
                            /**
                              Component
                            **/
                        
                            label {
                                width: 100%;
                            }
                        
                            .card-input-element {
                                display: none;
                            }
                        
                            .card-input {
                                margin: 10px;
                                padding: 0px;
                            }
                        
                            .card-input:hover {
                                cursor: pointer;
                            }
                        
                            .card-input-element:checked + .card-input {
                                 box-shadow: 0 0 1px 1px #1E90FF;
                            }
                        
                        
                        </style>

						<div class="form-group row">
							<label for="value" class="col-sm-3 col-form-label">Pilih Metode</label>
			    			<div class="col-sm-9">
					  			
						        <div class="row">
        						<!-- menyusun ulang metode pembayaran-->
        						<?php 
        						$g = 0;
        						foreach ($dtByIDkas as $kas) : 
        						    $g++;
        						    ?>
        						    <div class="col-sm-4">
                                            
                                        <label>
                                          <input type="radio" name="kas" value="<?= $kas['id_kas']; ?>" class="card-input-element" <?= ($g == 1) ? "required='required'" : null; ?>/>
                                            <div class="card card-default card-input">
                                              <div class="card-body bg-success text-white"><?= $kas['nm_kas']; ?></div>
                                            </div>

                                        </label>
                                        
                                    </div>
        						<?php endforeach; ?>
    							</div>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="value" class="col-sm-3 col-form-label">Tagihan Aktif</label>
			    			<div class="col-sm-9">
							    <input type="text" class="form-control" value="<?= 'Rp. '.number_format($tagihan_saat_ini,0,',','.').' ,-'; ?>" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label for="value" class="col-sm-3 col-form-label">Terima Pembayaran sebesar</label>
			    			<div class="col-sm-9">
							    <input type="text" class="form-control" id="value" name="value" placeholder="Nilai Piutang" value="<?= number_format($tagihan_saat_ini,0,',','.'); ?>" required="">
							    <small class="text-primary">*Ubah nominal sesuai yang dibayarkan pelanggan</small>
							</div>
						</div>
						<div class="form-group row">
							<label for="value" class="col-sm-3 col-form-label">Dibayar oleh : </label>
			    			<div class="col-sm-9">
							    <input type="text" class="form-control" id="dibayar" name="dibayar" placeholder="Nama Pembayar" value="" required="">
							</div>
						</div>
						<div class="form-group row">
							<label for="value" class="col-sm-3 col-form-label">Diterima oleh :</label>
			    			<div class="col-sm-9">
							    <input type="text" class="form-control" id="diterima" name="diterima" placeholder="Nama Penerima" value="" required="">
							</div>
						</div>
					</div>
					<div class="modal-footer">
				        <button type="submit" class="btn btn-primary">Bayar & Print</button>
				     </div>
					</form>
				</div>
			</div>
		</div>
		
	</div>

  </div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script type="text/javascript">
	$(document).on("keyup", "#value", function() {
		//Menangani Input otomatis Format Ribuan
		let rupiah = $(this).val();

		$(this).val(formatRupiah(rupiah, 'Rp. '));

		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			let number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
		}
    });
    
    $(document).ready(function(){
        $("#button_bln_sekarang").click(function(){
            let bln = $('#bln_sekarang').val();
            
            let pesan = "Anda memilih bulan "+konversiAngkaKeBulan(bln);
            alert(pesan);
            
            $("#bln_saat_ini option[value='" + Number(bln) + "']").prop("selected", true).trigger('change');
        });
        
        function konversiAngkaKeBulan(angka) {
            // Membuat array dengan nama-nama bulan
          var namaBulan = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
          ];
        
          // Validasi angka agar berada dalam rentang 1-12
          if (angka >= 1 && angka <= 12) {
            // Mengambil nama bulan dari array berdasarkan indeks (angka - 1)
            return namaBulan[angka - 1];
          } else {
            // Mengembalikan pesan kesalahan jika angka tidak valid
            return "Angka bulan tidak valid";
          }
        }
    });
</script>