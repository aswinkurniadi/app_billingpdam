<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800"><?= $title;  ?></h1>
	    <div class="button">
	    	<a href="<?= base_url('tagihan/cek_pelunasan/'); ?>" class="btn btn-sm btn-primary shadow-sm mr-1 mb-1">
		        <i class="fas fa-fw fa-search fa-sm text-white-50"></i>
		        <span class="text">Cek Pelunasan</span>
		    </a>
	    </div>
	</div>	

  	<div class="row clearfix">
	  	<div class="col-lg-12">

			<?= $this->session->flashdata('message'); ?>
			
		</div>
	</div>


	<!-- <div class="row mt-3 mb-4">
        <div class="col-sm">
            <div class="card border-bottom-primary shadow">
                <div class="col-sm">
                    <div class="mt-2 mb-2">
                        <div class="card-body">
                            <form action="" method="post" class="form-inline">
                                <div class="form-group col-sm-3">
                                    <label for="bln" class="col-sm-5 col-form-label">Bulan</label>
                                    <div class="col-sm-7">
								    	<select type="text" class="form-control bootstrap-select" id="bln" name="bln" title="Pilih Bulan" data-container="body" data-live-search="true">
								    		<?php foreach ($dt_bulan as $row) : ?>
								    			<?php if($row['id'] == $bln_select) { $selected = 'selected'; } else { $selected = ''; } ?>
												<option value="<?= $row['id']; ?>" <?= $selected; ?>><?= $row['nama']; ?></option>
											<?php endforeach; ?>
							  			</select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="tglAkhir" class="col-sm-5 col-form-label">Tahun</label>
                                    <div class="col-sm-7">
								    	<select type="text" class="form-control bootstrap-select" id="thn" name="thn" title="Pilih Tahun" data-container="body" data-live-search="true">
								    		<?php foreach ($dt_tahun as $row) : ?>
								    			<?php if($row['nama'] == $thn_select) { $selected = 'selected'; } else { $selected = ''; } ?>
												<option value="<?= $row['nama']; ?>" <?= $selected; ?>><?= $row['nama']; ?></option>
											<?php endforeach; ?>
							  			</select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-3 justify-content-center">
                                    <button type="submit" class="btn btn-success mr-3">
                                        <span class="icon text-white-50">
                                          <i class="fas fa-fw fa-filter"></i>
                                        </span>
                                        <span class="text">Filter</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="row mb-3">
    	<div class="col-sm-6">
          	<h6 class="m-0 font-weight-bold text-primary">Tabel Piutang Pelangan</h6>
      	</div>        		
	</div>

    <div class="row">
		<div class="table-responsive">
	  		<table class="table table-striped table-bordered table-sm" style="width:100%" id="tabel-data">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">ID PLNG</th>
			      <th scope="col">Nama</th>
			      <th scope="col">Alamat</th>
			      <th scope="col">No Telp</th>
			      <th scope="col">Paket</th>
			      <th scope="col">Nomor Air</th>
			      <th scope="col">Iuran Bulanan</th>
			      <th scope="col">Tagihan Saat Ini</th>
			      <th scope="col">Action</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $i = 1; 
			  	$total_blm_lunas = 0;
    			foreach ($data_blm_tertagih as $row) : 
    			?>
    		  		<tr>
    			      	<th scope="row"><?= $i++; ?></th>
    			      	<td><?= $row['no_plng']; ?></td>
    			      	<td><?= $row['nm']; ?></td>
    			      	<td><?= $row['almt']; ?></td>
    			      	<td><?= $row['no_telp']; ?></td>
    			      	<td><?= $row['paket']; ?></td>
    			      	<td><?= $row['nomor_air']; ?></td>
    			      	<td><?= $row['nilai']; ?></td>
    			      	<td class="text-right"><?= $row['tag_saat_ini']; ?></td>
    			      	<td>
                            <a href="<?= base_url('receivablenew/detailReceivable/'.$row['id_plng']) ?>" class="badge badge-success">
                                <span class="icon text-white-50">
                                    <i class="fas fa-fw fa-eye"></i>
                                </span>
                                <span class="text">Detail</span>
                            </a>
                        </td>
    			    </tr>
    		  	<?php 
    		  	    $total_blm_lunas += intval($row['tag_saat_ini']);
    		  	endforeach; ?>
			  </tbody>
			  <tfoot>
			      <tr>
			          <td colspan="9" class="text-right">Jumlah</td>
			          <td class="text-right"><?= number_format($total_blm_lunas,0,',','.'); ?></td>
			          <td></td>
			      </tr>
			  </tfoot>
			</table>
		</div>
	</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<script>
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
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}
    });

 
</script>
