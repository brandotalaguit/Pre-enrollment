<link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/bootstrap/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-tooltip.js"></script>
<div class="hero" style="text-align:center">
	<div class="alert alert-block alert-info">
	    <h1><img src="<?php echo base_url();?>assets/img/icon_home.png" class="thumnails"> Are you a <?php echo $residency; ?> resident?</h1>
	    <div class="form-actions">
	        <a href="<?php echo base_url(); ?>index.php/student/scholarship" class="btn btn-large btn-success"><i class="icon icon-ok icon-white"></i> YES</a>
	        <a href="<?php echo base_url(); ?>index.php/student/residency_process" id="no" class="btn btn-large btn-danger"><i class="icon icon-remove icon-white"></i> NO</a>
	    </div>
	</div>
</div>
