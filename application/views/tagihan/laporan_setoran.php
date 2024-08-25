<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800"><?= $title;  ?></h1>

	    <a href="" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambahSetoran">
	        <i class="fas fa-fw fa-plus fa-sm text-white-50"></i>
	        <span class="text">Tambah</span>
	    </a>
	    
	</div>	

  	<div class="row clearfix">
	  	<div class="col-lg-12">

			<?= $this->session->flashdata('message'); ?>
			
		</div>
	</div>

    <div class="row">
    	<div class="col-sm">
			<div class="card border-bottom-primary shadow mb-4">
	            <div class="card-header py-3">
		          	<h6 class="m-0 font-weight-bold text-primary">Tabel <?= $title;  ?></h6>
	            </div>
				<div class="card-body">            
					<div class="table-responsive">
				  		<table class="table table-striped table-bordered table-sm" style="width:100%" id="tabel-data">
						  <thead>
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Tanggal</th>
						      <th scope="col">User</th>
						      <th scope="col">Keterangan</th>
						      <th scope="col">Nominal</th>
						      <th scope="col">File</th>
						      <th scope="col">Sudah Disetorkan?</th>
		  					<?php if(is_admin()) { ?>
						      <th scope="col">Action</th>
		  					<?php } ?>
						    </tr>
						  </thead>
						  <tbody>
						  	<?php 
						  	$i = 1;
						  	foreach($dt_setoran as $row) : ?>
						  		<tr>
						  			<td><?= $i++; ?></td>
						  			<td><?= $row['tgl'];  ?></td>
						  			<td><?= $row['name']; ?></td>
						  			<td><?= $row['ket']; ?></td>
						  			<td><?= 'Rp. '.number_format($row['nilai'],0,',','.').' ,-'; ?></td>
						  			<td><?php
							  			if($row['file'] != '') {
								  			$url = base_url('assets/file/setoran/'.$row['file']); 
								  			$name = $row['file'];
								  			$color = "success";
								  		} else {
								  			$url = '';
								  			$name = 'File tidak ada';
								  			$color = "secondary";							  			
								  		}
							  			?>
						  				
						  				<a href="<?= $url; ?>" class="badge badge-<?= $color; ?>"><?= $name; ?></a>
						  			</td>
						  			<td>
						  				<?php 
						  				if($row['stts'] == 0) {
							  				$res_array = array(
							  					'id_setoran' => $row['id_setoran'],
							  					'stts' => 1,
							  				);
							  				$dt_id = base64_encode(json_encode($res_array));
						  					// status belum diterima
						  					?>	
						  					<?php if(is_admin()) { ?>
						  						<a href="<?= base_url('tagihan/ubah_status_setoran/'.$dt_id); ?>" class="badge badge-secondary">Belum Diterima</a>
						  					<?php } else { ?>
						  						<span class="badge badge-secondary">Belum Diterima</span>
						  					<?php 
								  				}
						  				} else {
							  				$res_array = array(
							  					'id_setoran' => $row['id_setoran'],
							  					'stts' => 0,
							  				);
							  				$dt_id = base64_encode(json_encode($res_array));
						  					// status diterima
						  					?>
						  					<?php if(is_admin()) { ?>
						  						<a href="<?= base_url('tagihan/ubah_status_setoran/'.$dt_id); ?>" class="badge badge-success">Sudah</a>
						  					<?php } else {?>
						  						<span class="badge badge-success">Sudah</span>
						  					<?php 
								  				}
						  				}

						  				?>
						  			</td>

				  					<?php if($row['stts'] == 0) { ?>
								    <td class="text-center">
								      		<a href="" class="badge badge-primary updateMenu" data-toggle="modal" data-target="#updateMenu"
								      			data-id_setoran="<?= $row['id_setoran'] ?>"
								      			data-ket="<?= $row['ket'] ?>"
								      			data-tgl="<?= $row['tgl'] ?>"
								      			data-nilai="<?= $row['nilai'] ?>"
								      			data-file="<?= $row['file'] ?>"
								      		>
								      			<span class="icon text-white-50">
												  	<i class="fas fa-fw fa-edit"></i>
												</span>
												<span class="text">Edit</span>
											</a>
								      		<a href="<?= base_url(); ?>tagihan/delete_setoran/<?= $row['id_setoran']; ?>" class="badge badge-danger" onclick="return confirm('yakin?');">
								      			<span class="icon text-white-50">
												  	<i class="fas fa-fw fa-trash"></i>
												</span>
												<span class="text">Delete</span>
								      		</a>
								    </td>
				  					<?php } else { ?>
				  						<td></td>
				  					<?php } ?>
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
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- Modal -->
<div class="modal fade" id="tambahSetoran" tabindex="-1" role="dialog" aria-labelledby="tambahSetoranLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahSetoranLabel">Tambah Setoran</h5>
      </div>

    <?= form_open_multipart('tagihan/add_setoran'); ?>
      	<div class="modal-body">
      		<div class="form-group row">
                <label for="tgl" class="col-sm-4 col-form-label">Tanggal</label>
                <div class="col-sm-8">
                	<input type="date" id="tgl_tambah" name="tgl"  value="<?= $now; ?>" class="form-control" required="">
                </div>
            </div>
      		<div class="form-group row">
                <label for="ket" class="col-sm-4 col-form-label">Keterangan</label>
                <div class="col-sm-8">
                	<textarea class="form-control" id="ket" name="ket" cols="1" rows="3" placeholder="Masukkan keterangan" required=""></textarea>
                </div>
            </div>
      		<div class="form-group row">
                <label for="nilai" class="col-sm-4 col-form-label">Nilai</label>
                <div class="col-sm-8">
                	<input type="number" id="nilai" name="nilai" class="form-control" placeholder="Masukkan nilai" required="">
                </div>
            </div>            
			<div class="form-group">
		    	<div class="row">
	                <label for="file" class="col-sm-4 col-form-label">Upload</label>
		    		<div class="col-sm-8">
		    			<div class="custom-file">
						  <input type="file" class="custom-file-input" id="file" name="file">
						  <label class="custom-file-label" for="image">Choose File</label>
						</div>
		    		</div>
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
<div class="modal fade" id="updateMenu" tabindex="-1" role="dialog" aria-labelledby="updateMenuLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateMenuLabel">Ubah Setoran</h5>
      </div>
      <?= form_open_multipart('tagihan/update_setoran'); ?>
      	<div class="modal-body">

        	<input type="hidden" id="update_id_setoran" name="id_setoran" class="form-control" required="">
      		<div class="form-group row">
                <label for="tgl" class="col-sm-4 col-form-label">Tanggal</label>
                <div class="col-sm-8">
                	<input type="date" id="tgl_update" name="tgl" class="form-control">
                </div>
            </div>
      		<div class="form-group row">
                <label for="ket" class="col-sm-4 col-form-label">Keterangan</label>
                <div class="col-sm-8">
                	<textarea class="form-control" id="ket_update" name="ket"  cols="1" rows="3" placeholder="Masukkan keterangan" required=""></textarea>
                </div>
            </div>
      		<div class="form-group row">
                <label for="nilai" class="col-sm-4 col-form-label">Nilai</label>
                <div class="col-sm-8">
                	<input type="number" id="nilai_update" name="nilai" class="form-control" placeholder="Masukkan nilai" required="">
                </div>
            </div>            
			<div class="form-group">
		    	<div class="row">
	                <label for="file" class="col-sm-4 col-form-label">Upload</label>
		    		<div class="col-sm-8">
		    			<div class="custom-file">
						  <input type="file" class="custom-file-input" id="file" name="file">
						  <label class="custom-file-label" for="image">Choose File</label>
						</div>
						<small class="text-danger">*Upload file jika ingin mengubah file sebelumnya</small>
						<span id="link_url_file"></span>
		    		</div>
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

	$(".updateMenu").click(function(){
		let id_setoran = $(this).data('id_setoran');
		let ket = $(this).data('ket');
		let tgl = $(this).data('tgl');
		let nilai = $(this).data('nilai');
		let file = $(this).data('file');

		$('#id_setoran_update').val(id_setoran);
		$('#ket_update').val(ket);
		$('#tgl_update').val(tgl);
		$('#nilai_update').val(nilai);

		if(file != '') {
			var value = '<?= base_url('assets/file/setoran/'); ?>' + file;
			var url = `<a href="${value}" class="badge badge-success">Buka File</a>`;
			$('#link_url_file').html(url);
		}
	});
</script>