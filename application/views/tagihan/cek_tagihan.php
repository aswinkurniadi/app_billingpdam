<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800"><?= $title;  ?></h1>


	    <form action="<?= base_url('tagihan/ubah_cabang') ?>" method="post" class="form-inline">
	      <div class="form-group mb-2 mr-2">
	        <select class="form-control" name="cabang" id="cabang" required="">
	            <option value="">Pilih Kantor</option>
	            <?php foreach($cabang as $cab) : ?>
	              <option value="<?= $cab['id_cabang']; ?>" <?= ($id_cabang == $cab['id_cabang']) ? "selected" : null; ?>><?= $cab['nama']; ?></option>
	            <?php endforeach; ?>
	        </select>
	      </div>
	      <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-save"></i></button>
	    </form>


	</div>	

  	<div class="row clearfix">
	  	<div class="col-lg-12">

			<?= $this->session->flashdata('message'); ?>
			
		</div>
	</div>



	<div class="row mt-3 mb-4">
        <div class="col-sm">
            <div class="card border-bottom-primary shadow">
                <div class="col-sm">
                    <div class="mt-2 mb-2">
                        <div class="card-body">
                            <form action="" method="post">

							<!-- <div class="col-sm"> -->
								<div class="row">
								                                            
									<div class="col-sm-3">
                        				<div class="form-group row">
		                                    <label for="tglAwal" class="col-sm-5 col-form-label">Tgl Awal</label>
		                                    <div class="col-sm-7">
		                                        <input type="date" class="form-control" id="tglAwal" name="tglAwal" value="<?= (isset($tgl_awal)) ? $tgl_awal : $now; ?>">
		                                        <?= form_error('tglAwal', '<small class="text-danger pl-3">', '</small>'); ?>
		                                    </div>
		                                </div>
                        			</div>

                        			<div class="col-sm-3">
                        				<div class="form-group row">
		                                    <label for="tglAkhir" class="col-sm-5 col-form-label">Tgl Akhir</label>
		                                    <div class="col-sm-7">
		                                        <input type="date" class="form-control" id="tglAkhir" name="tglAkhir" value="<?= (isset($tgl_akhir)) ? $tgl_akhir : $now; ?>">
		                                        <?= form_error('tglAkhir', '<small class="text-danger pl-3">', '</small>'); ?>
		                                    </div>
                        				</div>
                        			</div>

	                        		<div class="col-sm-3">
	                    				<div class="form-group row">
	                    					<label for="colektor" class="col-sm-5 col-form-label">Kolektor</label>
		                                    <div class="col-sm-7">
		                                        <select class="form-control " id="colektor" name="colektor" class="form-control">
														<option value="">All</option>
		                                        	<?php foreach($kolektor as $ko) : ?>
		                                        	<?php 
		                                        	       if(isset($id_col)) { 
		                                        	        	if($id_col == $ko['id_user']) {
		                                        	                $selected = 'selected';
			                                        	        } else {
			                                        	            $selected = null;
			                                        	        }
	    		                                            } else {
	    		                                                $selected = null;
	    		                                            }; ?>
														<option value="<?= $ko['id_user'] ?>" <?= $selected; ?>><?= $ko['name'] ?></option>
													<?php endforeach; ?>
												</select>
												<?= form_error('colektor', '<small class="text-danger pl-3">', '</small>'); ?>
		                                    </div>
	                    				</div>
	                    			</div> 
                            			
                            		<div class="col-sm-2">
                        				<div class="form-group row">
	                                	    <label for="value" class="col-sm-5 col-form-label">Metode</label>
                			    			<div class="col-sm-7">
                						    	<select type="text" class="form-control" id="kas" name="kas">
                						    	    <option value="">All</option>
                						    		<?php
                						    		foreach ($datakas as $kas) : 
		                                        	       if(isset($id_col)) { 
		                                        	        if($id_kas == $kas['id_kas']) {
		                                        	                $selected = 'selected';
    		                                        	        } else {
    		                                        	            $selected = null;
    		                                        	        }
        		                                            } else {
        		                                                $selected = null;
        		                                            }; ?>
                										<option value="<?= $kas['id_kas']; ?>" <?= $selected; ?>><?= $kas['nm_kas']; ?></option>
                									<?php endforeach; ?>
                					  			</select>
                							</div>
                        				</div>
                        			</div>

                        			<div class="col-sm-1">
                        				<div class="form-group">

                                            <button type="submit" class="btn btn-success mr-3">
                                                <span class="icon text-white-50">
                                                  <i class="fas fa-fw fa-filter"></i>
                                                </span>
                                                <span class="text">Filter</span>
                                            </button>
                        				</div>
                        			</div>


                        		</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    	<div class="col-sm-12">
    		<h6>Keterangan : </h6>
    		<p>1. pencarian berdasarkan tgl awal dan tgl akhir 
    			<br> 2. pencarian berdasarkan tgl awal, tgl akhir, dan agen 
    			<br> 3. pencarian berdasarkan tgl awal, tgl akhir, dan metode 
    			<br> 4. pencarian berdasarkan tgl awal, tgl akhir, agen, dan metode
    		</p>
    	</div>
    </div>



    <div class="row mb-3">
    	<div class="col-sm-6">
          	<h6 class="m-0 font-weight-bold text-primary">Tabel Piutang Pelangan</h6>
      	</div>
      	<div class="col-sm-6 text-right">
			<a href="" class="btn btn-sm btn-secondary shadow-sm text-left" data-toggle="modal" data-target="#eksporpiutint">
		        <i class="fas fa-fw fa-download fa-sm text-white-50"></i>
		        <span class="text">Download</span>
		    </a>
    		<button id="copy-all-button" class="btn btn-sm btn-primary">Salin Semua</button>
		</div>            		
	</div>

    <div class="row mb-2">
		<div class="table-responsive">
	  		<table class="table table-striped table-bordered table-sm" style="width:100%" id="tabel-data">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Kolektor</th>
			      <th scope="col">Tanggal Bayar</th>
			      <th scope="col">ID Plng</th>
			      <th scope="col">Cust</th>
			      <th scope="col">Alamat</th>
			      <th scope="col">Metode</th>
			      <th scope="col">Nominal</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php 
			  	$total = 0;
			  	if($status == 1) {
			  	$i = 1;
			  	foreach($repayment as $row) : 
			  	?>
			  		<tr>
			  			<td><?= $i++; ?></td>
			  			<td><?= $row['name']; ?></td>
			  			<td><?= $row['tgl'];  ?></td>
			  			<td><?= $row['no_plng']; ?></td>
			  			<td><?= $row['nm']; ?></td>
			  			<td><?= $row['almt']; ?></td>
			  			<td><?= $row['nm_kas']; ?></td>
			  			<td class="text-right"><?= number_format($row['nilai'],0,',','.'); ?></td>
			  		</tr>
			  	<?php 
			  	        $total += $row['nilai'];
			  	    endforeach; 
				} else {
			  	?>
			  	<tr>
			  		<td colspan="8" class="text-center">Data Tidak ditemukan</td>
			  	</tr>

				<?php } ?>
			  </tbody>
			  <tfoot>
			      <tr class="text-success">
			          <td colspan="7">Jumlah</td>
			          <td class="text-right"><?= number_format($total,0,',','.'); ?></td>
			      </tr>
			  </tfoot>
			</table>
		</div>
	</div>
	
	
  	<script>
        document.addEventListener('DOMContentLoaded', function() {
            const copyAllButton = document.getElementById('copy-all-button');
            const tabel1 = document.getElementById('tabel-data');
            const copyText = Array.from(tabel1.querySelectorAll('tbody tr'))
                .map(row => {
                    const rowData = Array.from(row.querySelectorAll('td'))
                        .map(cell => cell.textContent.trim())
                        .join('\t'); // Gunakan tab sebagai pemisah antara kolom
                    return rowData;
                })
                .join('\n'); // Gunakan baris baru sebagai pemisah antara baris
    
            copyAllButton.addEventListener('click', () => {
                copyToClipboard(copyText);
            });
            
            new ClipboardJS(copyAllButton);
        });
    
        function copyToClipboard(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('Seluruh baris telah disalin ke clipboard.');
        }
    </script>
	
	<div class="row">
		<div class="table-responsive">
	  		<table class="table table-striped table-bordered table-sm" style="width:100%" id="tabel-data">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">ID Plng</th>
			      <th scope="col">Jumlah</th>
			      <th scope="col">Cek Tagihan</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php 
			  	if($status == 1) {
			  	    $j = 1;
			  	foreach($data_duplikat as $row) : 
			  	    if($row['jml'] > 0) :
			  	    $duplikat = '<a href="'.base_url('receivablenew/detailReceivable/'.$row['id']).'" target="_BLANK"><span class="badge badge-success"><i class="fas fa-fw fa-copy"></i>cek</span></a>';
			  	?>
			  		<tr>
			  			<td><?= $j++; ?></td>
			  			<td><?= $row['id']; ?></td>
			  			<td><?= $row['jml']; ?></td>
			  			<td><?= $duplikat; ?></td>
			  		</tr>
			  	<?php 
			  	    endif;
			  	endforeach;
				} else {
			  	?>
			  	<tr>
			  		<td colspan="8" class="text-center">Data Tidak ditemukan</td>
			  	</tr>

				<?php } ?>
			  </tbody>
			</table>
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
        <h5 class="modal-title" id="eksporpiutintLabel">Ekspor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('receivablenew/eksport_cek_piutang'); ?>" method="post" target="__BLANK">
	      <div class="modal-body">
	        <div class="form-group">
			    <input type="date" class="form-control" id="tglAwal" name="tglAwal" value="<?= (isset($tgl_awal)) ? $tgl_awal : $now; ?>">
			</div>
	        <div class="form-group">
			    <input type="date" class="form-control" id="tglAkhir" name="tglAkhir" value="<?= (isset($tgl_akhir)) ? $tgl_akhir : $now; ?>">
			</div>
			<div class="form-group">
				<select class="form-control " id="colektor" name="colektor">
		    	    <option value="">Pilih Kolektor</option>
                	<?php foreach($kolektor as $ko) : ?>
                	<?php 
                	       if(isset($id_col)) { 
                	        if($id_col == $ko['id']) {
                	                $selected = 'selected';
                    	        } else {
                    	            $selected = null;
                    	        }
                            } else {
                                $selected = null;
                            }; ?>
						<option value="<?= $ko['id'] ?>" <?= $selected; ?>><?= $ko['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
    		<div class="form-group">
		    	<select type="text" class="form-control" id="kas" name="kas">
		    	    <option value="">Pilih Metode</option>
		    		<?php
		    		foreach ($datakas as $kas) : 
                	       if(isset($id_col)) { 
                	        if($id_kas == $kas['id_kas']) {
                	                $selected = 'selected';
                    	        } else {
                    	            $selected = null;
                    	        }
                            } else {
                                $selected = null;
                            }; ?>
						<option value="<?= $kas['id_kas']; ?>" <?= $selected; ?>><?= $kas['nm_kas']; ?></option>
					<?php endforeach; ?>
	  			</select>
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
