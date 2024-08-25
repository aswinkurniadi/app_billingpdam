<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800"><?= $title;  ?></h1>
        
	</div>

  	<div class="row clearfix">
	  	<div class="col-lg-12">

			<?= $this->session->flashdata('msg_putus'); ?>
			
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
						      <th scope="col">Nama</th>
						      <th scope="col">Waktu</th>
						      <th scope="col">Keterangan</th>
						  	</tr>
						  </thead>
						  <tbody>
						  	<?php $i = 1; ?>
				  			<?php foreach ($dtRiwayat as $row) : ?>
						    <tr>
						      <th width="5%" scope="row"><?= $i++; ?></th>
						      <td width="30%"><?= $row['name']; ?></td>
						      <td width="20%"><?= date("Y-m-d H:i",$row['waktu']); ?></td>
						      <td width="40%"><?= $row['ket']; ?></td>
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
    