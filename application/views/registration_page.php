<div class="content-fluid">
<!-- download data links -->
	<label>Enter date to download</label>
	<label class="checkbox inline pull-right"><input type="checkbox" id="all_data" name="all_data" value="1"> Collect data from the start</label>
	<input name="date" type="date" id="date" data-format="yyyy-mm-dd">
<div class="row-fluid">
	<div class="btn-group">
	<a href="<?php echo site_url('registration/migrate_printsec');?>" target="_blank" class="btn btn-danger download">
	<strong>
		<i class="icon-download-alt icon-white"></i> Printsec
	</strong>
	</a>	
	<a href="<?php echo site_url('registration/migrate_printmas');?>" target="_blank" class="btn btn-primary download">
	<strong>
		<i class="icon-download-alt icon-white"></i> Printmas
	</strong>	
	</a>		
	<a href="<?php echo site_url('registration/migrate_assessment');?>" target="_blank" class="btn btn-info download">
	<strong>
		<i class="icon-download-alt icon-white"></i> Assessment
	</strong>
	</a>	
	<a href="<?php echo site_url('registration/migrate_token_fee_payment');?>" target="_blank" class="btn btn-danger download">
	<strong>
		<i class="icon-download-alt icon-white"></i> Token Fee Payment
	</strong>
	</a>
	<a href="<?php echo site_url('registration/migrate_miscfee2');?>" target="_blank" class="btn download">
	<strong>
		<i class="icon-download-alt"></i> Misc Fees
	</strong>
	</a>
	<a href="<?php echo site_url('registration/migrate_miscfee_collection2');?>" target="_blank" class="btn btn-inverse download">
	<strong>
		<i class="icon-download-alt icon-white"></i> Misc Fees Collection
	</strong>
	</a>
	</div>
</div> <!-- end of download links -->

<!-- deactivate reservation of subject -->
<!--
<div class="row-fluid">
	
	<div class="form-vertical">
		<label>Enter validation date</label>
		<input name="validation_date" type="date" id="validation_date" data-format="yyyy-mm-dd">
		<a href="<?php echo site_url('registration/deactivate_unpaid_students');?>" 
			target="_blank"
			class="btn btn-primary validation">Remove Subject Reservation of Unpaid Students</a>	

	</div>
	
</div> 
-->
<!-- end of deactivate reservation-->

</div>
<script>
	$(function() {
		/*
		$('a.btn').click(function(){
			alert($("input[name=date]").val());
			$(this).attr('href',function() {
				return this.href +'/'+ $("input[name=date]").val();
			})
		});
		*/
		
		$('.download').click(function(){
			alert($('#date').val());
			$(this).attr('href',function() {
				if ($('#all_data').is(':checked')) 
				{
				return this.href + '/0/1';
				}
				else
				{
				return this.href + '/' + $('#date').val();
				}
			})
			window.reload();
		});
		
		$('.validation').click(function(){
			alert($('#validation_date').val());
			$(this).attr('href',function() {
				return this.href +'/'+ $('#validation_date').val();
			})
		});
		
		
	});
</script>