<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800"><?= $title;  ?></h1>
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

	<div class="row justify-content-center">
		<div class="col-sm">
			<div class="table-responsive">
		  		<table class="table table-striped table-bordered table-sm" style="width:100%;" id="tabel-data">
				  <thead>
				  	<tr>
				  		<td>Action</td>
				  		<td>ID & Tagihan</td>
				  		<td>Nama</td>
				  		<td>Alamat</td>
				  		<td>Paket</td>
				  		<td>Nomor</td>
				  	</tr>
				  </thead>
				  <tbody>
				  	<?php foreach($data AS $da) : ?>
				  	<?php $status = ($da['tagihan'] == 0 ||  $da['tagihan'] < 0) ? "Lunas" : "Belum Lunas"; ?>
			  		<?php $color = ($da['tagihan'] == 0 ||  $da['tagihan'] < 0) ? "success" : "danger"; ?>
			  		<?php $action = ($da['tagihan'] == 0 ||  $da['tagihan'] < 0) ? 0 : 1; ?>
				  	<tr>
				  		<td width="40px"><?php if($action == 1) { ?>
				  			<a href="<?= base_url('tagihan/detail_pencarian/'.$da['id_plng']); ?>" class="btn btn-sm btn-primary">
	                            <span class="icon text-white-50">
	                                <i class="fas fa-fw fa-eye"></i>
	                            </span>
	                            <span class="text">Detail</span>
	                        </a>
    	                    <?php } ?>
	                    </td>
				  		<td><?= $da['no_plng']; ?><span class="badge badge-<?= $color; ?>"><?= $status; ?></span>
				  			<br><?= 'Rp. '.number_format($da['tagihan'],0,',','.'); ?></td>
				  		<td><?= $da['nm']; ?></td>
				  		<td><?= $da['almt']; ?></td>
				  		<td><?= $da['paket']; ?></td>
				  		<td><?= $da['nomor_air']; ?></td>
				  	</tr>
				  	<?php endforeach; ?>
				  </tbody>
				</table>
			</div>
        </div>
	</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 