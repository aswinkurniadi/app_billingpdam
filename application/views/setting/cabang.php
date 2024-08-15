<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800 mb-3"><?= $title;  ?></h1>
	    <?php if (is_admin()) : ?>
		    <a href="" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambahcabang">
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
				  		<table class="table table-dataAkun table-striped table-bordered table-sm" id="tabel-data">
						  <thead class="text-center">
						  	<tr>
						      <th scope="col">#</th>
						      <th scope="col">Nama Cabang</th>
						      <?php if (is_admin()) : ?>
							      <th scope="col" rowspan="2">Action</th>
							  <?php endif; ?>
						  	</tr>
						  </thead>
						  <tbody>
						  	<?php $i = 1; ?>
				  			<?php foreach ($dt_all as $row) : ?>
						    <tr>
						      <th width="5%" scope="row"><?= $i++; ?></th>
						      <td width="40%"><?= $row['nama']; ?></td>
						      <?php if (is_admin()) : ?>
							      <td class="text-center" width="20%">
							      		<a href="" class="badge badge-primary updatecabang" data-toggle="modal" data-target="#updatecabang"
							      			data-id_cabang="<?= $row['id_cabang'] ?>"
							      			data-nama="<?= $row['nama'] ?>"
							      		>
							      			<span class="icon text-white-50">
											  	<i class="fas fa-fw fa-edit"></i>
											</span>
											<span class="text">Edit</span>
										</a>
							      		<a href="<?= base_url(); ?>cabang/delete/<?= $row['id_cabang']; ?>" class="badge badge-danger" onclick="return confirm('yakin?');">
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
<div class="modal fade" id="tambahcabang" tabindex="-1" role="dialog" aria-labelledby="tambahcabangLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahcabangLabel">Tambah Cabang</h5>
      </div>
      <form action="<?= base_url('cabang/add'); ?>" method="post">
      	<div class="modal-body">
      		<div class="form-group row">
                <label for="nama" class="col-sm-5 col-form-label">Nama cabang</label>
                <div class="col-sm-7">
                	<input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama Cabang" required="">
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
<div class="modal fade" id="updatecabang" tabindex="-1" role="dialog" aria-labelledby="updatecabangLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updatecabangLabel">Ubah cabang</h5>
      </div>
      <form action="<?= base_url('cabang/update'); ?>" method="post">
      	<div class="modal-body">
      		<div class="form-group row">
                <label for="bln" class="col-sm-5 col-form-label">Nama Cabang</label>
                <div class="col-sm-7">
                	<input type="hidden" id="update_id_cabang" name="id_cabang" class="form-control" required="">
                	<input type="text" id="update_nama" name="nama" class="form-control" placeholder="Masukkan Nama Cabang" required="">
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
	$(".updatecabang").click(function(){
		let id_cabang = $(this).data('id_cabang');
		let nama = $(this).data('nama');

		$('#update_id_cabang').val(id_cabang);
		$('#update_nama').val(nama);
	});
</script>