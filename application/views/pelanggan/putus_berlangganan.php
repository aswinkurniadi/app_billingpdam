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
    


    <div class="row mb-3">
    	<div class="col-sm-6">
          	<h6 class="m-0 font-weight-bold text-primary">Tabel <?= $title;  ?></h6>
      	</div>         		
	</div>

    <div class="row">
		<div class="table-responsive">
	  		<table class="table table-striped table-bordered table-sm" style="width:100%" id="tabel-data">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Berhenti Putus</th>
			      <th scope="col">Tgl Pasang</th>
			      <th scope="col">ID Plng</th>
			      <th scope="col">Cust</th>
			      <th scope="col">Alamat</th>
			      <th scope="col">No Telp</th>
			      <th scope="col">Nomor Air</th>
			      <th scope="col">Sisa Tagihan</th>
			      <th scope="col">Action</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php 
			  	$i = 1;
			  	foreach($dtPemutusan as $row) : ?>
			  		<tr>
			  			<td><?= $i++; ?></td>
			  			<td><?= $row['tgl_putus'];  ?></td>
			  			<td><?= $row['tgl'];  ?></td>
			  			<td><?= $row['no_plng']; ?></td>
			  			<td><?= $row['nm']; ?></td>
			  			<td><?= $row['almt']; ?></td>
			  			<td><?= $row['no_telp']; ?></td>
			  			<td><?= $row['nomor_air']; ?></td>
			  			<td align="right"><?= number_format($row['sisa_tagihan']); ?></td>
			  			<td>
			  				<a href="<?= base_url('tagihan/detail/'.$row['id_plng']); ?>" class="mb-1 btn btn-sm btn-success"><i class="fas fa-fw fa-eye"></i>Detail</a>
			  			</td>
			  		</tr>
			  	<?php endforeach; 
			  	?>
			  </tbody>
			</table>
		</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->