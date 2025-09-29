<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800 mb-3"><?= $title;  ?></h1>
	    <?php if (is_admin()) : ?>
		    <a href="" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambahpaket">
		        <i class="fas fa-fw fa-plus fa-sm text-white-50"></i>
		        <span class="text">Tambah</span>
		    </a>
	    <?php endif; ?>
	</div>

  	<div class="row clearfix">
	  	<div class="col-lg-12">

			<?= $this->session->flashdata('message'); ?>
			
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
	  		<div class="card border-bottom-primary shadow mb-4">
	            <div class="card-header py-3">
	              <h6 class="m-0 font-weight-bold text-primary">Tabel <?= $title;  ?></h6>
	            </div>
				<div class="card-body">
					<div class="table-responsive"> 
				  		<table class="table table-striped table-bordered table-sm" id="tabel-data">
						  <thead class="text-center">
						  	<tr>
						      <th scope="col">#</th>
						      <th scope="col">Tanggal</th>
						      <th scope="col">ID PLNG</th>
						      <th scope="col">Nama</th>
						      <th scope="col">Nilai Denda</th>
						      <th scope="col">Aksi</th>
						  	</tr>
						  </thead>
						  <tbody>
						  	<?php 
						  	$i = 1; 
						  	$total = 0;
						  	foreach ($dt_all as $row) : 
				  				$total += $row['nilai']; ?>
						    <tr>
						      <th width="5%" scope="row"><?= $i++; ?></th>
						      <td width="40%"><?= $row['nama']; ?></td>
						      <td width="40%"><?= number_format($row['nilai'],0,',','.'); ?></td>
						      <?php if (is_admin()) : ?>
							      <td class="text-center" width="20%">
							      		<a href="" class="badge badge-primary updatepaket" data-toggle="modal" data-target="#updatepaket"
							      			data-id_paket="<?= $row['id_paket'] ?>"
							      			data-nama="<?= $row['nama'] ?>"
							      			data-nilai="<?= $row['nilai'] ?>"
							      		>
							      			<span class="icon text-white-50">
											  	<i class="fas fa-fw fa-edit"></i>
											</span>
											<span class="text">Edit</span>
										</a>
							      		<a href="<?= base_url(); ?>paket/delete/<?= $row['id_paket']; ?>" class="badge badge-danger" onclick="return confirm('yakin?');">
							      			<span class="icon text-white-50">
											  	<i class="fas fa-fw fa-trash"></i>
											</span>
											<span class="text">Delete</span>
							      		</a>
							      </td>
							  <?php endif; ?>
						    </tr>
						    <?php endforeach; ?>
						  </tbody>
						  <tfoot>
						  	<tr>
						  		<td colspan="4"></td>
						  		<td align="right"><?= number_format($total,0,',','.'); ?></td>
						  		<td></td>
						  	</tr>
						  </tfoot>
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
<div class="modal fade" id="tambahpaket" tabindex="-1" role="dialog" aria-labelledby="tambahpaketLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahpaketLabel">Tambah paket</h5>
      </div>
      <form action="<?= base_url('paket/add'); ?>" method="post">
      	<div class="modal-body">
      		<div class="form-group row">
                <label for="nama" class="col-sm-5 col-form-label">Nama paket</label>
                <div class="col-sm-7">
                	<input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama Paket" required="">
                </div>
            </div>
      		<div class="form-group row">
                <label for="nilai" class="col-sm-5 col-form-label">Nilai</label>
                <div class="col-sm-7">
                	<input type="number" id="nilai" name="nilai" class="form-control" placeholder="Masukkan harga" required="">
                </div>
            </div>
    	</div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
       </div>
    </div>
  </form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="updatepaket" tabindex="-1" role="dialog" aria-labelledby="updatepaketLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updatepaketLabel">Ubah paket</h5>
      </div>
      <form action="<?= base_url('paket/update'); ?>" method="post">
      	<div class="modal-body">
      		<div class="form-group row">
                <label for="bln" class="col-sm-5 col-form-label">Nama paket</label>
                <div class="col-sm-7">
                	<input type="hidden" id="update_id_paket" name="id_paket" class="form-control" required="">
                	<input type="text" id="update_nama" name="nama" class="form-control" placeholder="Masukkan Nama Paket" required="">
                </div>
            </div>
      		<div class="form-group row">
                <label for="nilai" class="col-sm-5 col-form-label">Nilai</label>
                <div class="col-sm-7">
                	<input type="number" id="update_nilai" name="nilai" class="form-control" placeholder="Masukkan harga" required="">
                </div>
            </div>
    	</div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
       </div>
    </div>
  </form>
  </div>
</div>


<script type="text/javascript">
	$(".updatepaket").click(function(){
		let id_paket = $(this).data('id_paket');
		let nama = $(this).data('nama');
		let nilai = $(this).data('nilai');

		$('#update_id_paket').val(id_paket);
		$('#update_nama').val(nama);
		$('#update_nilai').val(nilai);
	});
</script>