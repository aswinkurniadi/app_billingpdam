<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	    <h1 class="h3 mb-0 text-gray-800"><?= $title;  ?></h1>
        
	    <div class="row">
		    <a href="<?= base_url(); ?>pelanggan/add" class="btn btn-sm btn-primary shadow-sm mb-1">
		        <i class="fas fa-fw fa-plus fa-sm text-white-50"></i>
		        <span class="text">Tambah Pelanggan</span>
		    </a>
	    </div>
	</div>

  	<div class="row clearfix">
	  	<div class="col-lg-12">

			<?= $this->session->flashdata('message'); ?>
			
		</div>
	</div>
    

	<div class="row mb-3">
		<div class="col-sm-6">
			<h6 class="m-0 font-weight-bold text-primary">Tabel Data Pelangan</h6>
		</div>
	</div>
	
    <div class="row">
		<div class="table-responsive">
	  		<table class="table table-striped table-bordered table-sm" style="width:100%" id="table-serverside">
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
			      <th scope="col">Status</th>
			      <th scope="col">Action</th>
			    </tr>
			  </thead>
			  <tbody>
			  	
			  </tbody>
			</table>
		</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- Modal Update -->
<div class="modal fade" id="imporcustint" tabindex="-1" role="dialog" aria-labelledby="imporcustintLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imporcustintLabel">Impor Data Pelanggan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open_multipart('pelanggan/upload_excel_plng_int')?>
	      <div class="modal-body">
			<div class="form-group row">
                <div class="col-sm">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="excel" name="excel">
                        <label class="custom-file-label" for="excel">Choose file</label>
                    </div>
                </div>
            </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Add</button>
	      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
 
var table;
 
$(document).ready(function() {
 
    //datatables
    table = $('#table-serverside').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('pelanggan/ajax_list_pelanggan/')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
});
 

</script>
