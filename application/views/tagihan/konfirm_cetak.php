<!-- Begin Page Content -->
<div class="container-fluid">

  	<!-- Page Heading -->
  	<h1 class="h3 mb-4 text-gray-800"><?= $title;  ?></h1>

  	<div class="row clearfix">
	  	<div class="col-lg-12">

			<?= $this->session->flashdata('message'); ?>
			
		</div>
	</div>

  	<div class="row justify-content-center mt-3">
  		<button class="btn btn-lg btn-secondary shadow-sm mr-2 mb-2" onclick="ajax_print('<?= base_url('tagihan/print_struct?'.$myarray); ?>',this)">
  			<i class="fas fa-fw fa-print fa-sm text-white-50"></i>
  			<span class="text">Cetak</span>
  		</button>  		
    
    </div>

<!---->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

 <script type="text/javascript">
        function ajax_print(url, btn) {
            $.get(url, function (data) {
                var ua = navigator.userAgent.toLowerCase();
                var isAndroid = ua.indexOf("android") > -1;
                if(isAndroid) {
                    android_print(data);
                }else{
                    pc_print(data);
                }
            });
        }

        function android_print(data){
            window.location.href = data;
        }
        
        function pc_print(data){
            var socket = new WebSocket("ws://127.0.0.1:40213/");
            socket.bufferType = "arraybuffer";
            socket.onerror = function(error) {
              alert("Error");
            };
            socket.onopen = function() {
                socket.send(data);
                socket.close(1000, "Work complete");
            };
        }
</script>