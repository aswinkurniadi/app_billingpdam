<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800"><?= $title;  ?> (Akun : <span><?= $user['name'];  ?></span>)</h1>
	    
	</div>	

  	<div class="row clearfix">
	  	<div class="col-lg-12">

			<?= $this->session->flashdata('message'); ?>
			
		</div>
	</div>



    <div class="row justify-content-center">
		<div class="col-sm-12">
	  		<div class="card border-bottom-primary shadow mb-4">
	    	<!-- Topbar Search -->
	          	<form action="<?= base_url('tagihan/hasil_pencarian'); ?>" class="navbar-search mb-2 mt-2 ml-2 mr-2" method="post">
	            	<div class="input-group">
	              		<input type="text" class="form-control bg-light border-0 small" placeholder="Masukkan ID / Nama pelanggan" aria-label="Search" id="cari" name="cari">
	              		<div class="input-group-append">
	                		<button class="btn btn-primary" type="submit">
	                  			<i class="fas fa-arrow-right fa-sm"></i>
	                		</button>
	              		</div>
	            	</div>
	            	<hr>
	            	<div class="form-group">
					    <small id="emailHelp" class="form-text text-muted">Silahkan pilih salah satu metode pencarian dibawah ini.</small>
					    <label for="exampleInputEmail1">Berdasarkan : </label>
					    <div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="filter_by" id="inlineRadio1" value="1">
						  <label class="form-check-label" for="inlineRadio1">ID PLNG</label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="filter_by" id="inlineRadio2" value="2" checked="">
						  <label class="form-check-label" for="inlineRadio2">Nama PLNG</label>
						</div>
					</div>
	            	
	          	</form>
          	</div>
        </div>
	</div>




	<div class="row mt-3 mb-4">
        <div class="col-sm">
            <div class="card border-bottom-primary shadow">
            	
	            <div class="card-header">
	                <form action="" method="post" class="form-inline">
	                    <div class="form-group col-sm-3">
	                    	<div class="row">
	                            <label for="tglAwal" class="col-sm-5 col-form-label">Tanggal Awal</label>
	                            <div class="col-sm-7">
	                                <input type="date" class="form-control" id="tglAwal" name="tglAwal" value="<?= $tglawal; ?>">
	                                <?= form_error('tglAwal', '<small class="text-danger pl-3">', '</small>'); ?>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="form-group col-sm-3">
	                    	<div class="row">
	                            <label for="tglAkhir" class="col-sm-5 col-form-label">Tanggal Akhir</label>
	                            <div class="col-sm-7">
	                                <input type="date" class="form-control" id="tglAkhir" name="tglAkhir" value="<?= $tglakhir; ?>">
	                                <?= form_error('tglAkhir', '<small class="text-danger pl-3">', '</small>'); ?>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="form-group col-sm-3">
	                        <button type="submit" class="btn btn-success mr-3">
	                            <span class="icon text-white-50">
	                              <i class="fas fa-fw fa-filter"></i>
	                            </span>
	                            <span class="text">Filter</span>
	                        </button>
	                    </div>
	                </form>
	            </div>

	            <div class="card-body">


				    <div class="row mb-3">
				    	<div class="col-sm-6">
				          	<h6 class="m-0 font-weight-bold text-primary">Tabel Data Terlunasi</h6>
				      	</div>
				      	<div class="col-sm-6 text-right">
							<a href="" class="btn btn-sm btn-secondary shadow-sm text-left" data-toggle="modal" data-target="#eksporpiutint">
						        <i class="fas fa-fw fa-download fa-sm text-white-50"></i>
						        <span class="text">Download</span>
						    </a>
						</div>            		
					</div>

				    <div class="row">
						<div class="table-responsive">
					  		<table class="table table-striped table-bordered table-sm" style="width:100%" id="tabel-data">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Waktu</th>
							      <th scope="col">Kolektor</th>
							      <th scope="col">ID Plng</th>
							      <th scope="col">Cust</th>
							      <th scope="col">Alamat</th>
							      <th scope="col">Metode</th>
							      <th scope="col">Nominal</th>
							      <th scope="col">Action</th>
							    </tr>
							  </thead>
							  <tbody>
							  	<?php 
							  	$i = 1;
							  	foreach($repayment as $row) : ?>
							  		<tr>
							  			<td><?= $i++; ?></td>
							  			<td><?= $row['tgl'];  ?></td>
							  			<td><?= $row['name']; ?></td>
							  			<td><?= $row['no_plng']; ?></td>
							  			<td><?= $row['nm']; ?></td>
							  			<td><?= $row['almt']; ?></td>
							  			<td><?= $row['nm_kas']; ?></td>
							  			<td><?= 'Rp. '.number_format($row['nilai'],0,',','.').' ,-'; ?></td>
							  			<td>
							  				<a href="<?= base_url('tagihan/preview/'.$row['id_piut']); ?>" class="mb-1 btn btn-sm btn-success"><i class="fas fa-fw fa-eye"></i>Detail</a>
							  			</td>
							  		</tr>
							  	<?php endforeach; 
							  	?>
							  </tbody>
							</table>
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

<div class="modal fade" id="eksporpiutint" tabindex="-1" role="dialog" aria-labelledby="eksporpiutintLabel" aria-hidden="true">
 	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
		        <h5 class="modal-title" id="eksporpiutintLabel">Download Laporan PDF</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">&times;</span>
		        </button>
	      	</div>

	      	<form action="<?= base_url('tagihan/download_laporan_penagihan'); ?>" method="post" target="__BLANK">
		    <input type="hidden" class="form-control" id="colektor" name="colektor" value="<?= $user['id_user']; ?>">
	      	<div class="modal-body">
		        <div class="form-group">
				    <input type="date" class="form-control" id="tglAwal" name="tglAwal" value="<?= $tglawal; ?>">
				</div>
		        <div class="form-group">
				    <input type="date" class="form-control" id="tglAkhir" name="tglAkhir" value="<?= $tglakhir; ?>">
				</div>
	      	</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Ekspor</button>
	    	</div>
	      </form>
	 	</div>
  	</div>
</div>
