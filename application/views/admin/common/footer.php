 
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->

	<script src="<?php echo $this->config->item('assets_url')?>plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="assets/crossbrowserjs/html5shiv.js"></script>
		<script src="assets/crossbrowserjs/respond.min.js"></script>
		<script src="assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?php echo $this->config->item('assets_url')?>plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="<?php echo $this->config->item('assets_url')?>plugins/DataTables/js/jquery.dataTables.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>js/table-manage-default.demo.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
			TableManageDefault.init();
		});
	</script>

</body>

</html>
